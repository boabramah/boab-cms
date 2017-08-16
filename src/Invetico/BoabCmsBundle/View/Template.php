<?php

namespace Invetico\BoabCmsBundle\View;

use Invetico\BoabCmsBundle\View\Theme;
use Twig\Environment;

class Template extends AbstractTemplate implements TemplateInterface
{
    protected $title;
    protected $theme;
    protected $blocks = [];
    protected $masterLayout;
    protected $themeManager;
    protected $unbindKeys = [];
    protected $htmlData = [];

    public function __construct(Environment $twigEngine, ViewLocator $locator, ThemeManager $themeManager)
    {
        $this->twigEngine = $twigEngine;
        $this->locator = $locator;
        $this->themeManager = $themeManager;
    }

    public function render()
    {
        $this->reconcileThemeBlocks();
        foreach ($this->getBlocks() as $key => $value) {
            $this->fields[$key] =  $this->renderTemplate($value['template'], $this->fields);
        }

        return $this->renderTemplate($this->getMasterLayout(), $this->fields);
    }
    
    public function reconcileThemeBlocks()
    {
        $this->pageTitle = $this->getTitle();
        $this->themeManager->parseSettings();
        
        $themeBlocks = $this->themeManager->getBlocks();
        foreach ($this->getBlocks() as $key => $template) {
            if (isset($themeBlocks[$key])) {
                $themeBlocks[$key]['template'] = $template;
            }
        }
        $this->blocks = $themeBlocks;
        $this->setMasterLayout($this->themeManager->getMasterLayout());
    }

    public function bind($key, $value, $overWrite = false)
    {
        if (isset($this->fields[$key]) && !$overWrite) {
            throw new \InvalidArgumentException(sprintf('The key (%s) is already set. Set $overwrite to true to over write it',$key));
        }
        $this->fields[$key] = $value;

        return $this;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function load($template, array $data = [])
    {
        $view = new View($this->twigEngine->load($template), $this->locator);
        $view->setTemplate($template);
        $view->setData($data);

        return $view;
    }

    public function loadAsObject($class)
    {
        $object = new $class($this->twigEngine, $this->locator);
        if (!$object instanceof view) {
            throw new \InvalidArgumentException(sprintf('The view object %s must extends %s', $class, 'Invetico\BoabCmsBundle\View\View'));
        }
        //$object->setTemplate($object->getViewFile());
        return $object;
    }

    public function loadBlock($file = '')
    {
        if (empty($file)) {
            throw new \InvalidArgumentException("A block must be supplied");
        }

        return $this->fetch($file);
    }

    public function loadThemeBlock($template)
    {
        if (empty($template)) {
            throw new \InvalidArgumentException("A block must be supplied");
        }

        return $template;
    }

    public function loadThemeTemplate($template)
    {
        $view = new View($this->twigEngine, $this->locator);
        $view->setFile($template);

        return $view;
    }

    public function setBlock($key, $block, $overWrite = false)
    {
        if (isset($this->blocks[$key]) && !$overWrite) {
            throw new \InvalidArgumentException(sprintf('The block key %s has already been set.',$key));
        }
        $this->blocks[$key] = $block;

        return $this;
    }

    public function setBlocks(array $blocks = [], $overWrite = false)
    {
        foreach ($blocks as $key => $value) {
            $this->setBlock($key, $value, $overWrite);
        }

        return $this;
    }

    public function getBlocks()
    {
        return $this->blocks;
    }

    public function setTheme($theme)
    {
        $this->themeManager->setTheme($theme);
        $this->theme = $theme;
        return $this;
    }

    public function getTheme()
    {
        return $this->theme;
    }

    public function setMasterLayout($masterLayout)
    {
        $this->masterLayout = $masterLayout;
    }

    public function getMasterLayout()
    {
        return $this->masterLayout;
    }

    private function renderTemplate($template, $data)
    {
        $extension = $this->getExtension($template);
        switch ($extension) {
            case 'twig':
                $themeFile = sprintf('@%s/%s', $this->theme, $template);
                $html = $this->twigEngine->render($themeFile, $data);
                break;
            case 'php':
                $tplLocation = $this->themeManager->getThemeFile($template);
                $html = $this->__render($tplLocation, $this);
                break;
            default:
                throw new \InvalidArgumentException(sprintf("The template file %s extension is not supported", $template));
                break;
        }

        return $html;
    }
}
