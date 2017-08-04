<?php

namespace Invetico\BoabCmsBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FormRenderEvent extends Event
{
    private $form;
    private $entity;

    public function __construct($form, $entity)
    {
        $this->form = $form;
        $this->entity = $entity;
    }

    public function getForm()
    {
        return $this->form;
    }

    public function setForm($form)
    {
        $this->form = $form;
    }

    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    public function getEntity()
    {
        return $this->entity;
    }

}
