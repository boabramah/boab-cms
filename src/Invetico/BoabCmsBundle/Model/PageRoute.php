<?php
namespace Invetico\BoabCmsBundle\Model;


class PageRoute extends Route
{
	public function getCleanUrl($baseUrl='')
	{
		$url = $this->getPath();
		if( 0 === strpos($url, '/')){
			return $baseUrl . substr($url, 1, strlen($url));
		}
		return $url;
        
	}


}
