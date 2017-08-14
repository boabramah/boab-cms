<?php

namespace Invetico\BoabCmsBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Invetico\BoabCmsBundle\Entity\ContentInterface;

class EditContentEvent extends Event
{
    private $entity;

    public function __construct(ContentInterface $entity)
    {
        $this->entity = $entity;
    }


    public function getEntity()
    {
        return $this->entity;
    }


    public function setEntity($entity)
    {
        $this->entity = $entity;
    }
}
