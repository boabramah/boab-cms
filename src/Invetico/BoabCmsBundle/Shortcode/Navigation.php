<?php
/* Currency.php */
namespace Invetico\BoabCmsBundle\Shortcode;

use Invetico\BoabCmsBundle\Shortcode\BaseShortcode;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Invetico\BoabCmsBundle\Util\MenuWidgetBuilder;
use Invetico\BoabCmsBundle\Repository\MenuRepositoryInterface;
/**
 * Generate Currency symbols
 * @package Maiorano\Shortcodes\Library
 */
class Navigation extends BaseShortcode
{
    private $request;
    private $menuBuilder;
    private $repository;
    private $environment;

    /**
     * @var string
     */
    protected $name = 'navigation';
 
    /**
     * @var array
     */
    protected $attributes = [
        'style'=>'normal', 
        'path'=>'/',
        'id'=>''
    ];

    public function __construct(RequestStack $requestStack, MenuWidgetBuilder $menuBuilder, MenuRepositoryInterface $repository, $environment)
    {
        $this->request = $requestStack->getCurrentRequest();;
        $this->menuBuilder = $menuBuilder;
        $this->repository = $repository;
        $this->environment = $environment;
    }
 
    /**
     * @param string|null $content
     * @param array $atts
     * @return string
     */
    public function handle($content = null, array $atts=[])
    {
        $id = $atts['id'];
        $hash = md5($id);

        $cacheDir = sprintf(dirname(__DIR__) . '/../../../app/cache/%s/sitecache/',$this->environment);
 /*       
        if(!is_dir($cacheDir)){
            mkdir($cacheDir, 0755, true);
        }
        $cacheFile = sprintf('%s/%s.txt', $cacheDir, $hash);
*/
        return $this->getMenuList();

        if(!file_exists($cacheFile)){
            
            file_put_contents($cacheFile, $data);
        }
        return file_get_contents($cacheFile);
/*
        if($atts['path'] === $this->request->getPathInfo()){
            return file_get_contents($cache);
        }
        return '';
        */
    }


    private function getMenuList()
    {
        $menus = $this->repository->findAllVisibleMenus();
        return $this->menuBuilder->getFrontEndNavigation($menus, $this->request->attributes->get('routeDocument'));
    }

}