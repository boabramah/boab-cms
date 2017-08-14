<?php
namespace Invetico\BoabCmsBundle\Service;


use Invetico\BoabCmsBundle\Entity\StaticMenu;
use Bundle\PageBundle\Repository\PageRepositoryInterface;
use Invetico\BoabCmsBundle\Service\BaseService;
use Invetico\BoabCmsBundle\Repository\MenuRepositoryInterface;
use Invetico\BoabCmsBundle\Helper\EventDispatcherHelper;
use Symfony\Cmf\Component\Routing\RouteProviderInterface;

Class MenuService extends BaseService
{
    private $menuRepository;

    use EventDispatcherHelper;
    
    
    function __Construct(MenuRepositoryInterface $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }


    public function create( $entity , $request = null)
    {
        return $this->trigger($entity,'create');
    }

    public function update($entity, $request=null)
    {
        return $this->trigger($entity,'update');
    }

    public function populateEntity( $entity, $request ){}


    public function createEntity()
    {
        return new StaticMenu();
    }


    public function findAll()
    {
        return $this->menuRepository->getAllMenus();
    }


    public function findById($id)
    {
        return $this->findMenuByOne(['id' => $id]);
    }


    public function findByUrl($url)
    {
        return $this->findMenuByOne(['url'=>$url]);
    }

    public function findBySlug($url)
    {
        return $this->findMenuByOne(['slug'=>$url]);
    }


    private function findMenuByOne( array $criteria = [])
    {
        return $this->menuRepository->findOneBy($criteria);
    }


    public function findRouteChildren($parentId)
    {
        return $this->menuRepository->getMenuItemChildren($parentId);
    }

    public function initMenuBuilder()
    {
        $items = $this->findAll();
        return $this->buildParentChild($items);
    }

    public function getMenuItemsAsOption()
    {

    }


    public function delete($menuItem)
    {
        if($this->menuRepository->getMenuItemChildren($menuItem->getId())){
            throw new \Exception(sprintf('The menu item <b>%s</b> has child menu items and must be deleted first',$menuItem->getTitle()));
        }
        return parent::delete($menuItem);
    }


    public function orderMenuList($request)
    {
        $link_string = $request->get('order');
        $link_string = substr($link_string , 0 ,strlen($link_string)-1);
        $linkArray = explode('-',$link_string);
        
        $items = $this->findAll();
        $newItems = [];
        $menuItems = [];
        foreach($items as $item){
            $newItems[$item->getId()] = $item->getPosition();
            $menuItems[$item->getId()] = $item;
        }
        
        $count = 0;
        foreach($linkArray as $key => $id){
            if($newItems[$id] != $key){
                $menuItems[$id]->setPosition($key);
                $this->entityManager->persist($menuItems[$id]);
                $count++;
            }
        }
        $this->entityManager->flush();
        
        return $count;
    }


}
