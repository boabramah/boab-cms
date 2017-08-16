<?php

namespace Invetico\BoabCmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Cmf\Component\Routing\RouteObjectInterface;

/**
 * DynamicMenuNode
 *
 * @ORM\Entity(repositoryClass="Invetico\BoabCmsBundle\Repository\MenuRepository")
 */
class ControllerAwareMenuNode extends Menu implements RouteObjectInterface
{

    /**
     * @var string
     *
     * @ORM\Column(name="controller", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    protected $controller;	

    /**
     * @var string
     *
     * @ORM\Column(name="content_type", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    protected $contentType;	      

    /**
     * Set controller
     *
     * @param string $controller
     * @return ControllerAwareMenuNode
     */
    public function setController($controller)
    {
        $this->controller = $controller;

        return $this;
    }

    /**
     * Get controller
     *
     * @return string 
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Set contentType
     *
     * @param string $contentType
     * @return ControllerAwareMenuNode
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;

        return $this;
    }

    /**
     * Get contentType
     *
     * @return string 
     */
    public function getContentType()
    {
        return $this->contentType;
    }


    public function getContentTypeId()
    {
        return $this->getContentType();
    }
}