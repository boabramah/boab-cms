<?php

namespace Invetico\BoabCmsBundle\EventListener;


use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Invetico\BoabCmsBundle\Service\MenuService;
use Invetico\BoabCmsBundle\Entity\StaticMenuNode;
use Invetico\BoabCmsBundle\Entity\DynamicMenuNode;
use Invetico\BoabCmsBundle\Entity\ControllerAwareMenuNode;
use Invetico\BoabCmsBundle\Entity\Content;
use Invetico\BoabCmsBundle\Entity\MenuNodeInterface;


class MenuListener
{
	private $menuService;
	private $request;

	public function __construct(MenuService $menuService)
	{
		$this->menuService = $menuService;
	}


	public function onKernelRequest(GetResponseEvent $event)
	{
		$this->request = $event->getRequest();

	}


	public function onContentCreateEvent($event)
	{
		$entity = $event->getEntity();
		if(!$this->request->get('menu_enable')){
			return;
		}

		$menu = new \Invetico\BoabCmsBundle\Entity\DynamicMenuNode();
		$menu = $this->populateNewMenuNode($menu);
		$entity->setMenu($menu);

		$event->setEntity($entity);
	}


	public function onContentUpdatedEvent($event)
	{
		$content = $event->getEntity();
		if(!$content instanceof Content){
			return;
		}		
		$menuEntity = $content->getMenu();

		if(!$this->request->get('menu_enable')){
			$content->setMenu(null);
			$event->setEntity($content);
			return;
		}
		
		if(!$content->hasRoute()){
			$menuEntity = new \Invetico\BoabCmsBundle\Entity\DynamicMenuNode();
			$menu = $this->populateNewMenuNode($menuEntity);
			$content->setMenu($menu);
			$event->setEntity($content);
			return;
		}

		$menu = $this->populateMenuEntity($menuEntity);
		$content->setMenu($menu);
		return;
	}


	public function onMenuCreatedEvent($event)
	{	
		$entity = $event->getEntity();
		if(!$entity instanceof MenuNodeInterface){
			return;
		}

		//echo get_class($entity);
		//die;

		//if($event->getName() === 'entity.pre_create'){
			$entity->setPosition(0.1);
			$entity->setDateCreated(new \DateTime);
		//}
		$menu = $this->populateMenuEntity($entity);
		if($menu instanceof ControllerAwareMenuNode){
			$this->setControllerAwareMenuNodeExtraSetting($menu);
		}
		$event->setEntity($menu);
	}


	public function onMenuUpdatedEvent($event)
	{
		$entity = $event->getEntity();
		
		$entityClass = get_class($entity);
		$allowedClass = ['Invetico\BoabCmsBundle\Entity\StaticMenuNode','Invetico\BoabCmsBundle\Entity\ControllerAwareMenuNode'];
		if(!in_array($entityClass, $allowedClass)){
			return;
		}

		$menu = $this->populateMenuEntity($entity);
		if($menu instanceof ControllerAwareMenuNode){
			$this->setControllerAwareMenuNodeExtraSetting($menu);
		}		
		$event->setEntity($menu);	
		$event->stopPropagation();
	}


	public function populateMenuEntity($menu)
	{
		$menu->setTitle($this->request->get('menu_title'));
		$menu->setSlug(clean_url($this->request->get('menu_title')));
		$menu->setRouteName($this->request->get('route_name'));
		$menu->setParentId((int)$this->request->get('menu_parent_id'));
		$menu->setVisibility( $this->request->get('menu_visibility') ? 1 : 0);
		$menu->setExtraConfig( $this->request->get('extra_config') ? 1 : 0);
		$menu->setTemplate($this->request->get('menu_page_template'));

		$path = trim($this->request->get('menu_path'));
		$menu->setPath($this->getActualPath($menu, $path));

		return $menu;
	}


	private function getActualPath(MenuNodeInterface $menu, $path)
	{
		if($menu->isAbsoluteUrl($path)){
			return $path;
		}	

		if(empty($path) AND !$menu->hasParentSelected()){
			return str_replace('//','/','/'.$menu->getSlug());
		}		

		if(empty($path) AND $menu->hasParentSelected()){
			$parentPath = '';
			$parent = $this->menuService->findById($menu->getParentId());
			$parentPath .= $parent->getPath();
			return str_replace('//','/',$parentPath .'/'.$menu->getSlug());			
		}

		return $path;
	}


	private function setControllerAwareMenuNodeExtraSetting(ControllerAwareMenuNode $menu)
	{
		$menu->setController($this->request->get('controller_name'));
		$menu->setContentType($this->request->get('content_type'));	
	}


	private function populateNewMenuNode($entity)
	{
		$entity->setPosition(0.1);
		$entity->setDateCreated(new \DateTime);	
		return $this->populateMenuEntity($entity);
	}

}