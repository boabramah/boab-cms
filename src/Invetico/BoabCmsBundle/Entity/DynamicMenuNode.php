<?php

namespace Invetico\BoabCmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DynamicMenuNode
 *
 * @ORM\Entity(repositoryClass="Invetico\BoabCmsBundle\Repository\MenuRepository")
 */
class DynamicMenuNode extends Menu
{
  	public function getCleanUrl($baseUrl='')
	{
		if('/' === $this->getPath()){
			return $baseUrl;
		}
		return $baseUrl . substr($this->getPath(), 1, strlen($this->getPath()));
	}

    public function getContentTypeId()      	
    {
        return 'page';
    }	
}