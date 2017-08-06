<?php

namespace Invetico\BoabCmsBundle\View;

use Twig\TemplateWrapper;

class View extends AbstractTemplate implements TemplateInterface
{
    private $template;

    public function __construct(TemplateWrapper $twigEngine, ViewLocator $locator)
    {
        $this->twigEngine = $twigEngine;
        $this->locator = $locator;
    }

    public function setTemplate($template)
    {
        $this->template = $template;
    }

    public function getTemplate()
    {
        return $this->template;
    }

    public function render(array $data = [])
    {
        $this->fields = array_merge($this->fields, $data);
        $template = $this->getTemplate();
        if ('twig' === $this->getExtension($template)) {
            return $this->twigEngine->render($this->fields);
        }
        $template = $this->locator->load($template);

        return $this->__render($template);
    }

    public function __toString()
    {
        return $this->render([]);
    }

    public function partial($template, array $data = [])
    {
        $tpl = clone($this);
        $tpl->setData($data);
        $tpl->setTemplate($template);
        return $tpl->render([]);
    }


}