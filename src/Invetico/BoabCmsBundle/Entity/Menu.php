<?php

namespace Invetico\BoabCmsBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Bundle\FrameworkBundle\Entity\AbstractEntity;
use Bundle\FrameworkBundle\Entity\DocumentInterface;
use Symfony\Cmf\Bundle\RoutingBundle\Model\Route;
use Symfony\Cmf\Component\Routing\RouteObjectInterface;

/**
 * @ORM\Entity (repositoryClass="Invetico\BoabCmsBundle\Repository\MenuRepository")
 * @ORM\Table(name="menu")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="menu_type", type="string")
 * @ORM\DiscriminatorMap({
 "dynamic_node" = "DynamicMenuNode", 
 "static_node" = "StaticMenuNode", 
 "taxonomy_node"="TaxonomyMenuNode",
 "controller_aware_node"="ControllerAwareMenuNode"})
 */
abstract class Menu extends Route implements MenuNodeInterface
{
    const VISIBILITY_OFF = 0;
    const VISIBILITY_ON = 1;
    const ROUTE_PREFIX = 'route_';
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
   protected $path;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    protected $slug;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    protected $position;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", precision=0, scale=0, nullable=false, unique=false)
     */
    protected $dateCreated;

    /**
     * @var integer
     *
     * @ORM\Column(name="visibility", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    protected $visibility;

    /**
     * @var integer
     *
     * @ORM\Column(name="parent_id", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    protected $parentId;

    /**
     * @var string
     *
     * @ORM\Column(name="route_name", type="string", length=255, precision=0, scale=0, nullable=true, unique=true)
     */
    protected $routeName;   

    /**
     * @var string
     *
     * @ORM\Column(name="template", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    protected $template;    

    /**
     * @var integer
     *
     * @ORM\Column(name="extra_config", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    protected $extraConfig; 

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Menu
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Menu
     */
    public function setPath($path)
    {
        $this->path = (!$path) ? $this->getSlug() : $path;  
        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Menu
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }


    /**
     * Set position
     *
     * @param integer $position
     * @return Menu
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return Menu
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime 
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set visibility
     *
     * @param integer $visibility
     * @return Menu
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;

        return $this;
    }

    /**
     * Get visibility
     *
     * @return integer 
     */
    public function getVisibility()
    {
        return $this->visibility;
    }


    public function isVisible()
    {
        return (bool)$this->getVisibility();
    }

    /**
     * Set parentId
     *
     * @param integer $parentId
     * @return Menu
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
     * Set routeName
     *
     * @param string $routeName
     * @return Menu
     */
    public function setRouteName($routeName)
    {
        $this->routeName = $routeName;

        return $this;
    }

    /**
     * Get routeName
     *
     * @return string 
     */
    public function getRouteName()
    {
        return (!$this->routeName) ? sprintf('%s%s',self::ROUTE_PREFIX, $this->getId()) : $this->routeName;
    }   

    /**
     * Set template
     *
     * @param string $template
     * @return Content
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Get template
     *
     * @return string 
     */
    public function getTemplate()
    {
        return $this->template;
    }      

    /**
     * Set extraConfig
     *
     * @param integer $extraConfig
     * @return Menu
     */
    public function setExtraConfig($extraConfig)
    {
        $this->extraConfig = $extraConfig;

        return $this;
    }

    /**
     * Get extraConfig
     *
     * @return integer 
     */
    public function getExtraConfig()
    {
        return $this->extraConfig;
    }

    public function hasExtraConfig()
    {
        return (bool) $this->getExtraConfig();
    }


    public function getCleanUrl($baseUrl='')
    {
        if($this->isAbsoluteUrl()){
            return $this->getPath();
        }
        if('/' === $this->getPath()){
            return $baseUrl;
        }
        return $baseUrl . substr($this->getPath(), 1, strlen($this->getPath()));
    }      


    public function getRouteKey()
    {
        return $this->getRouteName();
    }


    public function hasParentSelected()
    {
        return (bool)$this->getParentId();
    }

    public function isAbsoluteUrl($url='') 
    {
        $url = $url !='' ? $url : $this->getPath();

        // First check: is the url just a domain name? (allow a slash at the end)
        $_domain_regex = "|^[A-Za-z0-9-]+(\.[A-Za-z0-9-]+)*(\.[A-Za-z]{2,})/?$|";
        if (preg_match($_domain_regex, $url)) {
            return true;
        }

        // Second: Check if it's a url with a scheme and all
        $_regex = '#^([a-z][\w-]+:(?:/{1,3}|[a-z0-9%])|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))$#';
        if (preg_match($_regex, $url, $matches)) {
            // pull out the domain name, and make sure that the domain is valid.
            $_parts = parse_url($url);

            //print_r($_parts);
            //exit;
            if (!in_array($_parts['scheme'], array( 'http', 'https' ))){
                return false;
            }

            // Check the domain using the regex, stops domains like "-example.com" passing through
            if (!preg_match($_domain_regex, $_parts['host'])){
                return false;
            }

            // This domain looks pretty valid. Only way to check it now is to download it!
            return true;
        }
        return false;
    }    
}
