<?php

namespace Invetico\BoabCmsBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class ContentImageUploadEvent extends Event
{
    private $content;
    private $files;

    public function __construct($content, $files)
    {
        $this->content = $content;
        $this->files = $files;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setFiles($files)
    {
        $this->files = $files;
    }

    public function getFiles()
    {
        return $this->files;
    }
}
