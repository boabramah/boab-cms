<?php
/* Currency.php */
namespace Invetico\BoabCmsBundle\Library;
use Maiorano\Shortcodes\Contracts\ShortcodeInterface;
use Maiorano\Shortcodes\Contracts\AttributeInterface;
 
/**
 * Generate Currency symbols
 * @package Maiorano\Shortcodes\Library
 */
class Shortcode implements ShortcodeInterface, AttributeInterface
{
    public function getName()
    {
        return $this->name;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function handle()
    {

    }
}