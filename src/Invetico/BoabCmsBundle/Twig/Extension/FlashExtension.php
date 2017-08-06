<?php

namespace Invetico\BoabCmsBundle\Twig\Extension;

use Invetico\BoabCmsBundle\Util\Flash;

class FlashExtension extends \Twig_Extension
{
    private $flash;

    public function __construct(Flash $flash)
    {
        $this->flash = $flash;
    }


    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('flash_error', [$this, 'getFlashError']),
            new \Twig_SimpleFunction('flash_warning', [$this, 'getFlashWarning']),
            new \Twig_SimpleFunction('flash_info', [$this, 'getFlashInfo']),
        );
    }


    public function getFlashError($field, $flag = false)
    {
        die('I am in twig');
    }

    public function getFlashWarning($field, $flag = false)
    {

    }

    public function getFlashInfo($field, $flag = false)
    {

    }
}
