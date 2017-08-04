<?php

namespace Invetico\BoabCmsBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Invetico\BoabCmsBundle\Entity\ContentInterface;

class ContentAccessListener
{
    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        die(__CLASS__);

        if ($entity instanceof ContentInterface) {

        }
    }

    public function prePersist(LifecycleEventArgs $args) 
    {
        //$entity = $args->getEntity();
        //die(get_class($entity));
    }   
}