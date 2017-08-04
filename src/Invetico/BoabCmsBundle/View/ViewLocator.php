<?php

namespace Invetico\BoabCmsBundle\View;

class ViewLocator
{
	private $format = 'Bundle:Section:file';
	private $locations = [];
	private $baseRoot;

	public function __construct($baseRoot)
	{
		$this->baseRoot = $baseRoot;
	}

	public function setTemplatesLocation(array $bundles = [])
	{
		$this->locations = array_merge($this->locations,$bundles);
	}

	public function load($fileString)
	{
		$parts = explode(':',$fileString);
		$this->validateTemplate($parts);

		$object = new \ReflectionClass($this->locations[$parts[0]]);
		$bundleRoot = dirname(dirname($object->getFileName()));
		$fileRelativePath = $parts[0].'/Resources/views/'.ucFirst($parts[1]).'/'.strtolower($parts[2]).'.php';
		$fullFilePath = $bundleRoot .'/'.$fileRelativePath;
		$bundleFullPath = '@'.$fileRelativePath;
		
		if(!file_exists($fullFilePath) || !is_readable($fullFilePath)){
			throw new \InvalidArgumentException(sprintf('Unable to find view file %s', $bundleFullPath));
		}
		return $fullFilePath;
	}


	public function loadViewClass($fileString)
	{
		$parts = explode(':',$fileString);
		$this->validateTemplate($parts);
		$refObj = new \ReflectionClass($this->locations[$parts[0]]);
		$viewClass = '\\'.$refObj->getNamespaceName()."\\Resources\\views\\$parts[1]\\{$parts[2]}";
		return $viewClass;
	}


	private function validateTemplate($parts)
	{
		$fileString = implode(':', $parts);
		if(3 != count($parts)){
			throw new \InvalidArgumentException(sprintf('The view file (%s) format is not valid. Should be in the format %s', $fileString, $this->format));
		}
		if(!isset($this->locations[$parts[0]])){
			throw new \InvalidArgumentException(sprintf('The bundle section (%s) of the view file (%s) does not exist', $parts[0], $fileString));
		}		
	}
}