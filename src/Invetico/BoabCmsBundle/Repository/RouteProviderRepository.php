<?php

namespace Invetico\BoabCmsBundle\Repository;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Cmf\Component\Routing\RouteProviderInterface;
use Symfony\Component\Routing\RouteCollection;
use Invetico\BoabCmsBundle\Model\PageRoute;
use Invetico\BoabCmsBundle\Model\StaticRoute;
use Invetico\BoabCmsBundle\Repository\MenuRepositoryInterface;
use Invetico\BoabCmsBundle\Entity\ControllerAwareMenuNode;

class RouteProviderRepository implements RouteProviderInterface
{
	private $collection;
	private $repository;
	private $fetchedRoutes = [];
	private $menuRepository;

	public function __construct(MenuRepositoryInterface $menuRepository)
	{
		$this->menuRepository = $menuRepository;
	}

    /**
     * This method is used to generate URLs, e.g. {{ path('foobar') }}.
     */
    public function getRouteByName($name, $params = [])
    {
    	foreach ($this->menuRepository->getAllMenus() as $route) {
    		if($name == $route->getRouteName()){
    			return $route;
    		}
    	}
    }


    public function getRoutesByNames($names, $parameters = [])
    {
    	
    }

	
	public function getRouteCollectionForRequest(Request $request)
	{
		return $this->fetchAllRoutes($request);
	}


	private function fetchAllRoutes( $request = null )
	{
		$collection = new RouteCollection();
		foreach($this->menuRepository->getAllMenus() as $item){
			$this->setDefault($item, $collection);
			$collection->add('route_'.$item->getId(), $item);
			$this->fetchedRoutes['route_'.$item->getId()] = $item;
		}
        return $collection;
	}

	private function setDefault($item, $collection)
	{
		if($item instanceof ControllerAwareMenuNode){
			$item->setDefault('_controller',$item->getController());
			//$item->setDefault('_title',$item->getTitle());
			$collection->add($item->getRouteName(), $item);
		}
		$item->setDefault('_title',$item->getTitle());
		$item->setDefault('_template',$item->getTemplate());
	}	
	
}
