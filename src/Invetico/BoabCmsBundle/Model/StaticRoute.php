<?php
namespace Invetico\BoabCmsBundle\Model;


class StaticRoute extends Route
{

  	public function getCleanUrl($baseUrl='')
	{
		if('/' === $this->getPath()){
			return $baseUrl;
		}
		return $baseUrl . substr($this->getPath(), 1, strlen($this->getPath()));
	}


	public function setPath($path)
	{
		$path = empty($path) ? '/' : $path;
		parent::setPath($path);
	}

}
