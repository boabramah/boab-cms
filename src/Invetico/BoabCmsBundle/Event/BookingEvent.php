<?php

namespace Invetico\BoabCmsBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class BookingEvent extends Event
{
    private $info;

    public function __construct($info)
    {
        $this->info = $info;
    }

    public function getInfo()
    {
        return $this->info;
    }

}
