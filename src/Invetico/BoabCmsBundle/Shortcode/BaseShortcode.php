<?php

namespace Invetico\BoabCmsBundle\Shortcode;

use Maiorano\Shortcodes\Contracts\ShortcodeInterface;
use Maiorano\Shortcodes\Contracts\AttributeInterface;
 

abstract class BaseShortcode implements ShortcodeInterface, AttributeInterface
{
    public function getName()
    {
        return $this->name;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }


}