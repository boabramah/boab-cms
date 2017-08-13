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
     * @var integer
     *
     * @ORM\Column(name="parent_id", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    protected $parentId;

    /**
     * @var \Invetico\BoabCmsBundle\Entity\DynamicMenuNode
     *
     * @ORM\OneToOne(targetEntity="Invetico\BoabCmsBundle\Entity\DynamicMenuNode", cascade={"persist","remove"}, orphanRemoval=true)
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="menu_id", referencedColumnName="id", unique=true, nullable=true)
     * })
     */
    protected $menu;

    /**
     * Set parentId
     *
     * @param integer $parentId
     *
     * @return Content
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

    /**
     * Set menu
     *
     * @param  \Invetico\BoabCmsBundle\Entity\DynamicMenuNode $menu
     * @return Content
     */
    public function setMenu(\Invetico\BoabCmsBundle\Entity\DynamicMenuNode $menu = null)
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * Get menu
     *
     * @return \Invetico\BoabCmsBundle\Entity\DynamicMenuNode
     */
    public function getMenu()
    {
        return $this->menu;
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

    public function getStaffPosition()
    {
        //return explode('|',$this->getSummary())[0];
    }

    public function getMemberBioSummary()
    {
        //return explode('|',$this->getSummary())[1];
    }

}
