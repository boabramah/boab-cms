<?php

namespace Invetico\BoabCmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Invetico\BoabCmsBundle\Entity\ParentableInterface;
use Invetico\BoabCmsBundle\Entity\Content;
use Invetico\BoabCmsBundle\Entity\FileUploadInterface;
use Invetico\BoabCmsBundle\Model\SeoInterface;
use Invetico\BoabCmsBundle\Model\SeoTrait;

/**
 * Page
 * @ORM\Table(name="page")
 * @ORM\Entity(repositoryClass="Invetico\BoabCmsBundle\Repository\ContentRepository")
 */
class Page extends Content implements PageInterface, ParentableInterface, FileUploadInterface, SeoInterface
{
    private $subPages;

    use SeoTrait;

    private $discr = 'page';

    /**
     * Set parentId
     *
     * @param  integer $parentId
     * @return Page
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * Get parentId
     *
     * @return integer
     */
    public function getParentId()
    {
        return $this->parentId;
    }


    public function setSubPages($subPages)
    {
        $this->subPages = $subPages;
    }

    public function getSubPages()
    {
        return $this->subPages;
    }

    public function getUrl()
    {
        if(null === $this->getMenu()){
            return '';
        }
        if($this->getMenu()->isAbsoluteUrl($this->getMenu()->getPath())){
            return $this->getMenu()->getPath();
        }
    }

    public function getRouteName()
    {
        return $this->getMenu()->getRouteName();
    }    


    public function getContentTypeId()
    {
        return 'page';
    }

    public function getContentTypeLabel()
    {
        return 'Page';
    }

    public function getContentTypeDescription()
    {
        return 'Use for creating basic static content like <em>About Us</em>';
    }

    public function getStaffPosition()
    {
        //return explode('|',$this->getSummary())[0];
    }

    public function getMemberBioSummary()
    {
        //return explode('|',$this->getSummary())[1];
    }
      
}
