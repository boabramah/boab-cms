<?php

namespace Invetico\BoabCmsBundle\Twig\Extension;

use Invetico\BoabCmsBundle\Util\UtilCommon;

class BoabCmsExtension extends \Twig_Extension
{
    use UtilCommon;

    public function __construct()
    {
    }


    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('status_option', [$this, 'statusOption'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('status_style', [$this, 'status']),
        );
    }

}
