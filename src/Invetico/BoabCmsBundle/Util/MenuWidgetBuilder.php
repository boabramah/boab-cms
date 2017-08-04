<?php

namespace Invetico\BoabCmsBundle\Util;


use Symfony\Component\Routing\RouterInterface;
use Invetico\BoabCmsBundle\Service\MenuService;


class MenuWidgetBuilder
{
	private $menuService;
	private $router;
	private $menuItems;
	private $counter =0;
	private $padding = 5;

	public function __construct(MenuService $menuService, RouterInterface $router)
	{
		$this->menuService = $menuService;
		$this->router = $router;
	}


	private function buildParentChild( array $items = [])
	{
		$menuItems = [];
		// Builds the array lists with data from the menu table
		foreach($items as $item){
			// Creates entry into items array with current menu item id ie. $menu['items'][1]
			$menuItems['items'][$item->getId()] = $item;
			// Creates entry into parents array. Parents array contains a list of all items with children
			$menuItems['parents'][$item->getParentId()][] = $item->getId();
		}
		return $menuItems;
	}


	public function getMenuOptionList($menuItems, $selected='')
	{
		$menuItems = $this->buildParentChild($menuItems);
		return $this->menuOptionBuilder($menuItems, 0, $selected);
	}


	// Menu builder function, parentId 0 is the root
	private function menuOptionBuilder($menu, $parent, $parentId, $level=0)
	{
		if($this->counter > 0){
			$this->padding = $this->counter * 15;
		}
		$table = '';
		if (isset($menu['parents'][$parent])){
			foreach ($menu['parents'][$parent] as $itemId){
				if(isset($menu['items'][$itemId])){
					$item = $menu['items'][$itemId];
					$table .= '<option style="padding-left:'.$this->padding.'px" value="'.$item->getId().'"';
					$table .=($parentId == $itemId)?'class="bold" selected':'';
					$table .= '>'.$this->indentLevel($level).$item->getTitle().'</option>';
				}
	
				if(isset($menu['parents'][$itemId])){	
					$this->counter ++;
					$table .= $this->menuOptionBuilder($menu, $itemId, $parentId, $level + 1);
				}	
			}
			$this->padding = 5;
		}
	   return $table;
	}


	private function indentLevel($level)
	{
		$space = '';
		if($level === 0){return;}
		for ($i= 0; $i < $level+1; $i++){ $space .="&nbsp;"; }
		return $space;
	}

	public function getFrontEndNavigation($menuCollection, $selectedRoute)
	{
		$menuItems = $this->buildParentChild($menuCollection);
		return $this->buildNavigationMenu(0 , $menuItems, $selectedRoute);
	}


	// Menu builder function, parentId 0 is the root
	public function buildNavigationMenu($parent, $menu, $selectedRoute, $level = 1) 
	{
		$html = "";
		if (isset($menu['parents'][$parent])){
			$parentMenuItem = (1 === $level)? 'parent-menu-item':'sub-menu-item';
			foreach ($menu['parents'][$parent] as $itemId){
				$item = $menu['items'][$itemId];
				$class = (0 === $item->getParentId()) ? 'd-text-c-h' : 'd-text-c-h';
				$active = '';
				//$active = ($item->getId() === $selectedRoute->getId()) ? 'tg-active' : '';
				if(!isset($menu['parents'][$itemId])){
					$html .= '<li class="'. $active .'"><a  href="'. $item->getCleanUrl($this->router->generate('site_root')) .'">'.$item->getTitle().'</a></li>';
				}
				if(isset($menu['parents'][$itemId])){
					$html .= '<li><a href="#">'.$item->getTitle().'</a>';
					$html .= '<div class="drop">';
					$html .='<ul class="list-unstyled">';
					$html .= $this->buildNavigationMenu($itemId, $menu, $selectedRoute, $level + 1);
					$html .='</ul>';
					$html .='</div>';
					$html .= "</li> \n";
				}
			}
		}
		
	   return (1 === $level)? '<ul class="list-inline nav-top">' . $html .'</ul>':$html;
	}


	public function getMenuListTable($menuItems)
	{
		$menuItems = $this->buildParentChild($menuItems);
		return $this->menuListTableBuilder(0 , $menuItems);
	}


	public function menuListTableBuilder($parent , $menu)
	{
		//$counter = $this->counter;
		$this->padding = $this->counter > 0 ? $this->counter * 20 : 5;
		
		$table = '';
		if (isset($menu['parents'][$parent])){
			foreach ($menu['parents'][$parent] as $itemId){
				$item = $menu['items'][$itemId];
				//$link_title = $menu['items'][$itemId]['link_title'];
				//$order = $menu['items'][$itemId]['link_order'];
				if(!isset($menu['parents'][$itemId])){
					$table .= '<tr id="'.$item->getId().'">
									<td><input type="checkbox" name="checkbox[]" value="'.$item->getId().'" /></td>
									<td style="padding-left:'.$this->padding.'px">'.$item->getTitle().'</td>
									<td>'.$item->getRouteName().'</td>
									<td>'.$item->getPath().'</td>
									<td><a href="'.$this->router->generate('menu_admin_edit',['id'=>$item->getId()]).'">[edit]</a></td>
									<td><a href="'.$this->router->generate('menu_admin_delete',['id'=>$item->getId()]).'">[Delete]</a></td>
								</tr>';
				}
				if(isset($menu['parents'][$itemId])){	
					$table .= '<tr id="'.$item->getId().'">
									<td><input type="checkbox" disabled name="checkbox[]" value="'.$item->getId().'" /></td>
									<td style="padding-left:'.$this->padding.'px">'.$item->getTitle().'</td>
									<td>'.$item->getRouteName().'</td>
									<td>'.$item->getPath().'</td>
									<td><a href="'.$this->router->generate('menu_admin_edit',['id'=>$item->getId()]).'">[edit]</a></td>
									<td><a href="'.$this->router->generate('menu_admin_delete',['id'=>$item->getId()]).'">[Delete]</a></td>
								</tr>';
					$this->counter ++;
					$table .= $this->menuListTableBuilder($itemId, $menu);
				}	
			}
			$this->counter = 0;
			$this->padding = $this->counter == 0 ? 5 : 0;
		}
	   return $table;
	}


    public function buildMenu($menuItems)
    {
        $html = '<ul id="menu">';

        foreach($menuItems as $key => $item){
            $html .= $this->buildSubLinks($item);
        }
        $html .= '</ul>';

        return $html;

    }


    private function buildSubLinks($subItems)
    {
        $link = '<li>';
        foreach($subItems as $key =>$item){
            if($item['position'] === 1){
                $link .='<a href="'.$item['url'].'">'.$item['title'].'</a>';
                unset($subItems[$key]);
            }
        }    
        if(count($subItems) > 0){
            $link .= '<ul>';
            foreach($subItems as $key =>$item){
                if($item['position'] === 2){
                    $link .= '<li><a href="'.$item['url'].'">'.$item['title'].'</a></li>';
                }
            }
            $link .= '</ul>';
        }

        $link .= '</li>';

        return $link;
    }



}  