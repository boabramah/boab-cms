<?php

namespace Invetico\BoabCmsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\StringInput;

class CronTaskCommand extends ContainerAwareCommand
{
    private $output;

    protected function configure()
    {
        $this->setName('crontasks:run')
             ->setDescription('Runs Cron Tasks if needed');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<comment>Running Cron Tasks...</comment>');

        $this->output = $output;
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $crontasks = $em->getRepository('CronBundle:CronTask')->findAll();

        foreach($crontasks as $crontask){
            if (!$this->isRunnable($crontask)) {
                $output->writeln(sprintf('Skipping Cron Task <info>%s</info>', $crontask->getName()));
                continue;
            }
            $output->writeln(sprintf('Running Cron Task <info>%s</info>', $crontask->getName()));

            //Set $lastrun for this crontask
            $crontask->setLastRun(new \DateTime());
            try {
                $commands = $crontask->getCommands();
                foreach ($commands as $command) {
                    $output->writeln(sprintf('Executing command <comment>%s</comment>...', $command));
                    $this->runCommand($command);
                }
                $output->writeln('<info>SUCCESS</info>');
            } catch (\Exception $e) {
                $output->writeln(sprintf('<error>ERROR: %s </error>',$e->getMessage()));
            }
            $em->persist($crontask);
        }

        // Flush database changes
        $em->flush();

        $output->writeln('<comment>Done!</comment>');
    }


    private function isRunnable($crontask)
    {
        $date = $crontask->getLastRun();
        if (!$date) {
            return true;
        }
        $date->modify(sprintf('+%s minutes', $crontask->getInterval()));
        // Get the last run time of this task, and calculate when it should run next
        //$lastrun = $crontask->getLastRun() ? $crontask->getLastRun()->format('U') : 0;
        //$nextrun = $lastrun + $crontask->getInterval();
        //return (time() >= $nextrun);
        return (new \DateTime('Now') >= $date);
    }

    private function runCommand($string)
    {
        // Split namespace and arguments
        $namespace = split(' ', $string)[0];

        // Set input
        $command = $this->getApplication()->find($namespace);
        $input = new StringInput($string);

        // Send all output to the console
        $returnCode = $command->run($input, $this->output);

        return $returnCode != 0;
    }
}