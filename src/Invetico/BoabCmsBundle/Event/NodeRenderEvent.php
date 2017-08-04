<?php

namespace Invetico\BoabCmsBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class NodeRenderEvent extends Event
{
    private $node;
    private $view;

    public function __construct($node, $view)
    {
        $this->node = $node;
        $this->view = $view;
    }

    public function getNode()
    {
        return $this->node;
    }

    public function setNode($node)
    {
        $this->node = $node;
    }

    public function setView($view)
    {
        $this->view = $view;
    }

    public function getView()
    {
        return $this->view;
    }

}
