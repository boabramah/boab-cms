<?php

namespace Invetico\BoabCmsBundle\View;

interface ThemeManagerInterface
{
    public function setTheme($theme);

    public function getTheme();

    public function getTemplate($template);

    public function getBaseTemplate();
}