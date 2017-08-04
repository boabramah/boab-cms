<?php

namespace Invetico\BoabCmsBundle\Shortcode\HtmlEditor;


class Widget
{
    private $view;

    public function __construct($attr)
    {
        $this->view = $attr['view'];
    }

    public function getView()
    {
        return $this->view;
    }

}
