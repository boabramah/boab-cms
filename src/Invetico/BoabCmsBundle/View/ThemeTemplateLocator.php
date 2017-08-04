<?php

namespace Invetico\BoabCmsBundle\View;

class ThemeTemplateLocator 
{
	protected $baseThemeRoot;	
	protected $theme;
	
	function __construct($baseThemeRoot)
	{
		$this->baseThemeRoot = $baseThemeRoot;
	}
	
	public function setTheme($theme)
	{	
		$this->theme = $theme;
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
		$fileLocation = sprintf('%s/%s.php',$this->getThemeLocation(), $file);
		if(!file_exists($fileLocation) AND !is_readable($fileLocation)){
			throw new \InvalidArgumentException(sprintf('The theme file ( %s ) does not exit or readable',$fileLocation));
		}
		return $fileLocation;
	}
	
	public function getThemeLocation()
	{
		return sprintf('%s/%s',realpath($this->baseThemeRoot), $this->theme);
	}
	
}