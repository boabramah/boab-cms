<?php

namespace Invetico\BoabCmsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Invetico\BoabCmsBundle\Controller\AdminController;
use Invetico\BoabCmsBundle\Controller\InitializableControllerInterface;
use Invetico\BoabCmsBundle\Service\MenuService;
use Invetico\BoabCmsBundle\Util\MenuWidgetBuilder;
use Invetico\BoabCmsBundle\Validation\Form\MenuForm;

Class MenuController extends AdminController  implements InitializableControllerInterface 
{
    private $menuService;
    private $menuBuilder;

    function __Construct(MenuService $menuService, MenuWidgetBuilder $menuBuilder) 
    {
        $this->menuService = $menuService;
        $this->menuBuilder = $menuBuilder;
    }


    public function initialize()
    {
        $this->template->setTheme('novi');
    }


    public function indexAction(Request $request)
    {
        $view = $this->template->load('BoabCmsBundle:Admin:list_menus.html.twig');
        //$this->menuBuilder->setMenuItems($this->menuService->initMenuBuilder());
        $view->menuList = $this->menuBuilder->getMenuListTable($this->menuService->findAll());
        $this->template->setTitle('Menu List')
                     ->bind('page_header','Menu List')
                     ->bind('content',$view);

        return $this->template;
    }


    public function addAction(Request $request)
    {
        $view = $this->template->load('BoabCmsBundle:Admin:add_menu');
        $view->action = $this->router->generate('menu_admin_create');
        $view->parentOption = $this->menuBuilder->getMenuOptionList($this->menuService->findAll());
        $view->flash = $this->flash;
        
        $this->template->setTitle('Add Menu Item')
                     ->bind('page_header','Add Menu Item')
                     ->bind('content',$view);

        return $this->template;
    }


    public function createAction(Request $request)
    {
        $redirect = $this->router->generate('menu_admin_add');
        
        $menuForm = new MenuForm($request->request->all());
        if(!$menuForm->isValid()){
            $this->flash->setErrors($menuForm->getErrors());
            $this->flash->setValues($request->request->all());
            return $this->redirect($redirect);
        }
        $staticMenu = new \Invetico\BoabCmsBundle\Entity\StaticMenuNode();
        if($request->get('extra_config')){
            $staticMenu = new \Invetico\BoabCmsBundle\Entity\ControllerAwareMenuNode();
        }

        try{
            $results = $this->menuService->create($staticMenu, $request);
        }catch(\Exception $e){
            $this->flash->setSuccess($e->getMessage());
            return $this->redirect($redirect);
        }

        $this->flash->setSuccess('Menu item created successfully');
        return $this->redirect($redirect);
    }


    public function editAction(Request $request)
    {
        $id = $request->get('id');
        $view = $this->template->load('BoabCmsBundle:Admin:edit_menu');
        $view->action = $this->router->generate('menu_admin_update',['id'=>$request->get('id')]);
        $menu = $this->menuService->findById($id);
        $view->menu = $menu;
        $view->flash = $this->flash;
        $view->parentOption = $this->menuBuilder->getMenuOptionList($this->menuService->findAll(), $menu->getParentId());

        $this->template->setTitle('Edit Menu Item')
                     ->bind('page_header',$menu->getTitle())
                     ->bind('content',$view);

        return $this->template;

    }


    public function updateAction(Request $request)
    {
        $menuId = (int)$request->query->get('id');
        $menu = $this->menuService->findById($menuId);
        $results = $this->menuService->update($menu);
        $this->flash->setSuccess('Menu Item updated successfully');
        return $this->redirect($this->router->generate('menu_admin_edit',['id'=>$menuId]));
    }


    public function deleteAction(Request $request)
    {
        $id = $request->get('id');
        $menuItem = $this->menuService->findById($id);
        try{
            $results = $this->menuService->delete($menuItem);
        }catch(\Exception $e){
            $this->flash->setInfo($e->getMessage());
            return $this->redirect($this->router->generate('menu_admin_index'));
        }
        
        $this->flash->setSuccess(sprintf('The menu item <b>%s</b> deleted successfully',$menuItem->getTitle()));
        return $this->redirect($this->router->generate('menu_admin_index'));
    }


    public function reOrderMenuListAction(Request $request)
    {
        $results = $this->menuService->orderMenuList($request);
        exit("List re-arranged successfully");
    }
}
