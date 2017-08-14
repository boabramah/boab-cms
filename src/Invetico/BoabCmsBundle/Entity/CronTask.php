<?php

namespace Invetico\BoabCmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="cron_task")
 */
class CronTask
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="array")
     */
    private $commands;

    /**
     * @ORM\Column(name="`interval`", type="integer")
     */
    private $interval;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastrun;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getCommands()
    {
        return $this->commands;
    }

    public function setCommands($commands)
    {
        $this->commands = $commands;
        return $this;
    }

    public function getInterval()
    {
        return $this->interval;
    }

    public function setInterval($interval)
    {
        $this->interval = $interval;
        return $this;
    }

    public function getLastRun()
    {
        return $this->lastrun;
    }

    public function setLastRun($lastrun)
    {
        $this->lastrun = $lastrun;
        return $this;
    }
}