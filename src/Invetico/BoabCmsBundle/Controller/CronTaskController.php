<?php

namespace Invetico\BoabCmsBundle\Controller;

use Invetico\CronBundle\Entity\CronTask;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class CronTaskController extends Controller
{
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function testAction()
    {
        $entity = new CronTask();
        $entity->setName('Send Mails')
               ->setInterval(30) // Run once every hour
               ->setCommands(['swiftmailer:spool:send']);

        $em = $this->doctrine->getManager();
        $em->persist($entity);
        $em->flush();

        return new Response('OK!');
    }
}

