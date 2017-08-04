<?php
namespace Invetico\BoabCmsBundle\Shortcode\SimpleMenu;

use Invetico\BoabCmsBundle\Shortcode\BaseShortcode;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;


class SimpleMenu extends BaseShortcode
{
    private $router;
    private $authorizationChecker;
    private $template;

    /**
     * @var string
     */
    protected $name = 'simplemenu';
 
    /**
     * @var array
     */
    protected $attributes = ['template'=>''];

    public function __construct(RouterInterface $router, AuthorizationCheckerInterface $authorizationChecker, $template)
    {
        $this->router = $router;
        $this->authorizationChecker = $authorizationChecker;
        $this->template = $template;
    }
 
    /**
     * @param string|null $content
     * @param array $atts
     * @return string
     */
    public function handle($content = null, array $atts=[])
    {
        $data = $this->template->fetchInclude($atts['template']);
        $menuItems = $this->formatMenuItems($data);
        $items = $this->buildParentChild($menuItems);
        return '<ul class="menu accordion-menu">'.$this->buildNavigation($items,0).'</ul>';
    }

    private function buildNavigation($menuItems, $parent=0)
    {
        $childrenHtml = '';
        if(!isset($menuItems['parents'][$parent])){
            return;
        }
        foreach($menuItems['parents'][$parent] as $id){
            $item = $menuItems['items'][$id];

            if (!isset($menuItems['parents'][$id])){
                $childrenHtml .= sprintf('<li><a class="waves-effect waves-button" href="%s">%s</a></li>',$this->router->generate($item['route_name']),$item['title']); 
            }
            if (isset($menuItems['parents'][$id])) {
                $childrenHtml .= '<li class="droplink">';                     
                $childrenHtml .= '<a class="waves-effect waves-button" href="' . $this->router->generate($item['route_name']) .'"><p>'.$item['title'].'</p><span class="arrow"></span></a>';                
                $childrenHtml .= '<ul class="sub-menu">';         
                $childrenHtml .= $this->buildNavigation($menuItems, $item['id']);         
                $childrenHtml .= '</ul>';         
                $childrenHtml .= '</li>';           
            }
        }
        return $childrenHtml;       
    }    

    private function buildParentChild( array $items = [])
    {
        $menuItems = [];
        // Builds the array lists with data from the menu table
        foreach($items as $item){
            if(!$this->authorizationChecker->isGranted([$item['access_level']])){
                continue;
            }
            // Creates entry into items array with current menu item id ie. $menu['items'][1]
            $menuItems['items'][$item['id']] = $item;
            // Creates entry into parents array. Parents array contains a list of all items with children
            $menuItems['parents'][$item['parent_id']][] = $item['id'];
        }
        return $menuItems;
    }

    private function formatMenuItems($menuItems)
    {
        $menuTree = [];
        $hash = '';
        foreach($menuItems as $key => $item){
            if($item['position'] == 1){
                $hash = md5(time().$key);
                $item['id'] = $hash = $hash.$key;
                $item['parent_id'] = 0;
                $menuTree[]  = $item;
                continue;
            }
            $item['id'] = $hash . $key;
            $item['parent_id'] = $hash;
            $menuTree[] = $item;
        }  
        return $menuTree;      
    }
}