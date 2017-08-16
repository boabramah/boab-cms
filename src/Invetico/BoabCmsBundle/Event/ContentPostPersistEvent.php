<?php

namespace Invetico\BoabCmsBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Invetico\BoabCmsBundle\Entity\ContentInterface;

class ContentPostPersistEvent extends Event
{
    private $content;

    public function __construct(ContentInterface $content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }
}
