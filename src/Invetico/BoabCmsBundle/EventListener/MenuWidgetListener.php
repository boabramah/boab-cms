<?php

namespace Invetico\BoabCmsBundle\EventListener;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Cmf\Component\Routing\RouteProviderInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Invetico\BoabCmsBundle\Util\MenuWidgetBuilder;
use Invetico\BoabCmsBundle\Controller\AdminController;
use Invetico\BoabCmsBundle\Controller\AccountPanelInterface;
use Invetico\BoabCmsBundle\Event\EntityEvent;
use Invetico\BoabCmsBundle\Event\FormRenderEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Invetico\BoabCmsBundle\Repository\MenuRepositoryInterface;
use Invetico\BoabCmsBundle\View\Template;
use Invetico\BoabCmsBundle\Entity\ParentableInterface;
use Invetico\BoabCmsBundle\Entity\PageInterface;


class MenuWidgetListener implements EventSubscriberInterface
{
    private $template;
    private $menuWidgetBuilder;
    private $authorizationChecker;
    private $router;
    private $tokenStorage;
    private $cacheDir;
    private $matchedMenuItems = [];
    private $request;
    private $menuRepository;

    public function __construct
    (
        MenuWidgetBuilder $menuWidgetBuilder, 
        AuthorizationCheckerInterface $authorizationChecker, 
        Template $template, 
        RouterInterface $router,
        TokenStorageInterface $tokenStorage,
        MenuRepositoryInterface $menuRepository
    )
    {
        $this->menuWidgetBuilder = $menuWidgetBuilder;
        $this->authorizationChecker = $authorizationChecker;
        $this->template = $template;
        $this->router = $router;
        $this->tokenStorage = $tokenStorage;
        $this->menuRepository = $menuRepository;
    }


    public function onKernelRequest(GetResponseEvent $event)
    {
        if ($event->getRequestType() === HttpKernelInterface::SUB_REQUEST) {
            return;
        }

        $this->request = $event->getRequest();
        $routeParams = $this->request->attributes->get('_controller');
        $route = $this->request->attributes->get('routeDocument');
        if ($route) {
            $this->template->bind('sunMenuItems', $this->getSidebarSubMenuForRoute($route));
        }
    }

    public function onControllerEvent($event)
    {
        if ($event->getRequestType() === HttpKernelInterface::SUB_REQUEST) {
            return;
        }

        $controller = $event->getController();
        $userToken = $this->tokenStorage->getToken();
        if ($controller[0] instanceof AdminController || $controller[0] instanceof AccountPanelInterface) {

            $menuItems = unserialize(file_get_contents($this->cacheDir.'/menu_tree.txt'));
            $items = $this->buildParentChild($menuItems);

            $menu = $this->buildControlPanelSidebarNav($items, 0);
            $this->template->bind('controlPanelSidebarNav', $menu);

            $menu = $this->buildBankSidebarNav($items, 0);
            $this->template->bind('bankSidebarNavigation', $menu);

            $this->template->bind('controlPanelUserNav', $this->getControPanelUserNavbar($userToken->getUser()));

            return;
        }
    }

    public function onContentNodeRender($event)
    {
        $entity = $event->getNode();
        if ($entity instanceof PageInterface && $entity->getMenu() != false) {
            $this->template->bind('relatedLinks', $this->getRelatedRouteLinks($entity));
        }
    }

    private function getRelatedRouteLinks($entity)
    {
        $parentId = $entity->getMenu()->getParentId();
        $menuItems = $this->menuRepository->findAllRouteChildrenById($parentId);

        $view = $this->template->load('BoabCmsBundle:Widgets:related_links.html.twig');
        $view->collection = $menuItems;
        $view->currentRoute = $this->request->get('_route');
 
        return $view;
    }

    public function onFormRender(FormRenderEvent $event)
    {
        if (!$event->getEntity() instanceof PageInterface) {
            return;
        }
        $view = $event->getForm();
        $menuParentId = ($view->get('content')->getMenu()) ? $view->get('content')->getMenu()->getParentId() : '';
        $view->menuOptionList = $this->menuWidgetBuilder->getMenuOptionList($this->menuRepository->getAllMenus(), $menuParentId);
        $event->setForm($view);
    }

    private function getControPanelUserNavbar($user)
    {
        $view = $this->template->load('BoabCmsBundle:ToolBars:admin_authenticated_toolbar.html.twig');
        $view->user = $user;
        
        return $view->render();
    }

    private function getAdminAuthenticatedToolbar($userToken)
    {
        $view = $this->template->load('BoabCmsBundle:ToolBars:admin_authenticated_toolbar.html.twig');
        $view->user = $userToken;

        return $view->render();
    }

    private function buildControlPanelSidebarNav($menuItems, $parent=0)
    {
        $childrenHtml = '';
        if(!isset($menuItems['parents'][$parent])){
            return;
        }
        foreach($menuItems['parents'][$parent] as $id){
            $item = $menuItems['items'][$id];

            if (!isset($menuItems['parents'][$id])){
                $childrenHtml .= sprintf('<li><a href="%s">%s</a></li>',$this->router->generate($item['route_name']),$item['title']); 
            }
            if (isset($menuItems['parents'][$id])) {
                $childrenHtml .= '<li class="hasSub">';     	            
                $childrenHtml .= '<a href="' . $this->router->generate($item['route_name']) .'">'.$item['title'].'</a>'; 	            
                $childrenHtml .= $this->buildControlPanelSidebarNav($menuItems, $item['id']);         
                $childrenHtml .= '</li>';           
            }
        }
        return sprintf('<ul>%s</ul>', $childrenHtml);		
    }

    private function buildBankSidebarNav($menuItems, $parent=0)
    {
        $childrenHtml = '';
        if(!isset($menuItems['parents'][$parent])){
            return;
        }
        foreach($menuItems['parents'][$parent] as $id){
            $item = $menuItems['items'][$id];

            if (!isset($menuItems['parents'][$id])){
                $childrenHtml .= sprintf('<li><a href="%s">%s</a></li>',$this->router->generate($item['route_name']),$item['title']); 
            }
            if (isset($menuItems['parents'][$id])) {
                $childrenHtml .= '<li class="hasSub">';
                $childrenHtml .= '<a href="' . $this->router->generate($item['route_name']) .'">'.$item['title'].'</a>'; 	            
                $childrenHtml .= $this->buildControlPanelSidebarNav($menuItems, $item['id']);         
                $childrenHtml .= '</li>';
            }
        }
        return sprintf('<ul>%s</ul>', $childrenHtml);		
    }	

    private function buildParentChild( array $items = [])
    {
        $menuItems = [];
        // Builds the array lists with data from the menu table
        foreach ($items as $item) {
            if (!$this->authorizationChecker->isGranted([$item['access_level']])){
                continue;
            }
            // Creates entry into items array with current menu item id ie. $menu['items'][1]
            $menuItems['items'][$item['id']] = $item;
            // Creates entry into parents array. Parents array contains a list of all items with children
            $menuItems['parents'][$item['parent_id']][] = $item['id'];
        }
        return $menuItems;
    }


    public function setCacheDir($cacheDir ='')
    {
        $this->cacheDir = $cacheDir;
    }


    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => [['onKernelRequest']],
            KernelEvents::CONTROLLER => [['onControllerEvent', 50]],
            'content.form_render' => [['onFormRender', 50]],
            'content.node_render' => [['onContentNodeRender', 50]]
        ];
    }


    public function getUnAuthenticatedToolbar()
    {
        $view = $this->template->load('BoabCmsBundle:ToolBars:unauthenticated_toolbar.html.twig');
        $view->signup = $this->router->generate('user_register');
        $view->signin = $this->router->generate('_login');

        return $view->render();
    }


    public function getSidebarSubMenuForRoute($route)
    {
        if ($route->getParentId() == 0) {
            return;
        }
        $menuItems = $this->menuRepository->getMenuItemChildren($route->getParentId());

        return $this->createRouteView($menuItems);
    }

    private function getNavlistForRouteById($routId)
    {
        $menuItems = $this->menuRepository->findAllRouteChildrenById($routId);

        return $this->createRouteView($menuItems);
    }


    private function createRouteView($menuItems = [])
    {
        if (empty($menuItems)) {
            return '';
        }
        $view = $this->template->load('BoabCmsBundle:Widgets:sidebar_nav.html.twig');
        $view->menuItems = $menuItems;

        return $view->render();
    }
}
