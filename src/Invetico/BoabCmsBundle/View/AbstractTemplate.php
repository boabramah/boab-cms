<?php

namespace Invetico\BoabCmsBundle\View;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

abstract class AbstractTemplate
{
    protected $fields = array();
	protected $locator;
    protected $twigEngine;
    protected $extension;

    public function setData(array $data = [])
    {
        foreach($data as $key => $value){
            $this->fields[$key] = $value;
        }
    }

    public function set($key, $data)
    {
        $this->fields[$key] = $data;
        return $this;
    }

	public function __set($key, $data) 
	{
            $this->set($key, $data);
    }

    public function __get($field) 
    {
        return $this->get($field);
    }

    public function get($field)
    {
        if (!isset($this->fields[$field])) {
            return '';
        }
        $field = $this->fields[$field];
        if($field instanceof \Closure){
            return call_user_func($field);
        }
        if(is_object($field) AND $field instanceof TemplateInterface){
            return $field->render();
        }
        return $field;        
    }

    public function __call($method, $args)
    {
        if (!isset($this->fields[$method])) {
            throw new \InvalidArgumentException(sprintf('The view property %s you are accessing does not exist',$method));
        }
        return call_user_func_array($this->fields[$method], $args);
    }

    protected function __render($templateFile)
	{
        ob_start();
        require $templateFile;
        return ob_get_clean();
	}

    public function fetch($file)
    {
        return $this->locator->load($file);
    }

    public function fetchInclude($templateFile)
    {
        return include $this->fetch($templateFile);
    }

    protected function getExtension($templateFile)
    {
        $parts = explode('.',$templateFile);
        return end($parts);
    }    
}