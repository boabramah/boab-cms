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
            new \Twig_SimpleFunction('flash_error', [$this, 'getFlashError'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('flash_alert', [$this, 'getFlashAlert']),
            new \Twig_SimpleFunction('flash_info', [$this, 'getFlashInfo'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('flash_success', [$this, 'getFlashSuccess', ['is_safe' => ['html']]]),
            new \Twig_SimpleFunction('flash_data', [$this, 'getFlashData']),
        );
    }

    public function getFlashError($field, $flag = true)
    {
        return $this->flash->getError($field, $flag);
    }

    public function getFlashAlert($field, $flag = false)
    {
        return $this->flash->getAlert();
    }

    public function getErrorNotice()
    {
        return $this->flash->getErrorNotice();
    }

    public function getFlashInfo($flag = false)
    {
        return $this->flash->getInfo($flag);
    }

    public function getFlashSuccess($flag)
    {
        return $this->flash->getSuccesses($flag);
    }

    public function getFlashData($field, $default = '')
    {
        return $this->flash->getData($field) ? $this->flash->getData($field) : $default;
    }
}
