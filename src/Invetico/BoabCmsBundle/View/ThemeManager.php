<?php

namespace Invetico\BoabCmsBundle\View;

class ThemeManager 
{
	protected $blocks = array();
	protected $masterLayout;
	protected $baseThemeRoot;	
	protected $theme;
	protected $twigLoader;
	
	function __construct(\Twig_Loader_Filesystem $twigLoader, $baseThemeRoot)
	{
		$this->baseThemeRoot = $baseThemeRoot;
		$this->twigLoader = $twigLoader;
	}
	
	public function setTheme($theme)
	{	
		$this->theme = $theme;
		$this->twigLoader->addPath($this->getThemeLocation(), $theme);
	}


	public function fetchTemplate($template)
	{
		if(true == stripos($template, ':')){
			list($theme,$templateFile) = explode(':', $template);
			return sprintf('%s/%s/%s', $this->getThemeLocation(), $theme, $templateFile);
		}	
		return sprintf('%s/%s', $this->getThemeLocation(), $template);	
	}

	public function getThemeFile($file)
	{
		$fileLocation = sprintf('%s/%s',$this->getThemeLocation(), $file);
		if(!file_exists($fileLocation) AND !is_readable($fileLocation)){
			throw new \InvalidArgumentException(sprintf('The theme file ( %s ) does not exit or readable',$fileLocation));
		}
		return $fileLocation;
	}

	public function getThemeLocation()
	{
		return sprintf('%s/%s',realpath($this->baseThemeRoot), $this->theme);
	}


	public function getThemeSettings()
	{
		$themeSetting =  $this->getThemeLocation() .'/settings.xml';
		if(!file_exists($themeSetting) AND !is_readable($themeSetting)){	
			throw new \InvalidArgumentException("The settings file $themeSetting does not exit."); 
		}
		return simplexml_load_file($themeSetting);		
	}

	private function getformatedBlockData($settings)
	{
		$file = (string)$settings[0];
		$name = (string)$settings->attributes()['name'];
		$status = (string)$settings->attributes()['status'];
		$default = (string)$settings->attributes()['default'];

		$data[$name] = compact("file","name","status","default");
		return $data;
	}
	
	public function parseSettings()
	{
		$setting = $this->getThemeSettings();
		foreach($setting->regions->region as $block){
			$blockData = $this->getformatedBlockData($block);
			$this->blocks = array_merge($this->blocks,$blockData);
		}
		$this->masterLayout = (string)$setting->masterLayout;
	}

	public function getBlocks()
	{
		return $this->blocks;
	}

	public function getMasterLayout()
	{
		return $this->masterLayout;
	}
	
}