<?php
namespace Invetico\BoabCmsBundle\Model;

use Symfony\Cmf\Bundle\RoutingBundle\Model\Route as BaseRoute;
use Symfony\Cmf\Component\Routing\RouteObjectInterface;


class Route extends BaseRoute
{
    /**
     * Unique id of this route
     *
     * @var string
     */
    protected $contentId;
    protected $parent;
    protected $label;
    protected $routeId;
    protected $visible;


    public function setRoute($item)
    {
    	$this->setPath($item->getUrl());
		$this->setContentId($item->getPageId());
		$this->setParent($item->getParent());
		$this->setLabel($item->getTitle());
		$this->setRouteId($item->getId());
		$this->setVisible($item->getVisibility());
    }
	
	
	
	public function setContentId($id)
	{
		$this->contentId = $id;
	}
	
	
	public function getContentId()
	{
		return $this->contentId;
	}

	public function setParent($parent)
	{
		$this->parent = $parent;
	}
	
	
	public function getParent()
	{
		return $this->parent;
	}

	public function setLabel($label)
	{
		$this->label = $label;
	}
	
	
	public function getLabel()
	{
		return $this->label;
	}


	public function setRouteId($id)
	{
		$this->routeId = $id;
	}
	
	
	public function getRouteId()
	{
		return $this->routeId;
	}


	public function setVisible($visible)
	{
		$this->visible = $visible;
	}


	public function isVisible()
	{
		//echo $this->label .' -- '. $this->visible .'<br />';
		return (1 == $this->visible);
	}


}
