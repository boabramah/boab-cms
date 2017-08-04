<?php
/* Currency.php */
namespace Invetico\BoabCmsBundle\Shortcode;

use Invetico\BoabCmsBundle\Shortcode\BaseShortcode;
use Symfony\Component\HttpFoundation\Request;
use Invetico\BoabCmsBundle\Util\MenuWidgetBuilder;
use Invetico\BoabCmsBundle\Repository\MenuRepositoryInterface;
use Symfony\Component\Routing\RouterInterface;
/**
 * Generate Currency symbols
 * @package Maiorano\Shortcodes\Library
 */
class Router extends BaseShortcode
{
    private $router;
    private $template;

    /**
     * @var string
     */
    protected $name = 'link';
 
    /**
     * @var array
     */
    protected $attributes = [
        'view'=>'', 
        'cache'=>false,
        'default'=>''
    ];

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }
 
    /**
     * @param string|null $content
     * @param array $atts
     * @return string
     */
    public function handle($content = null, array $atts=[])
    {
        //var_dump($atts);
        //die;
        $routeParams = isset($atts['params']) ? $this->defaultToArray($atts['params']) : array();
        $path = $this->router->generate($atts['route_name'], $routeParams);
        $hashtag = isset($atts['hashtag']) ? $atts['hashtag'] : '';
        return sprintf('%s%s', $path, $hashtag);
    }


    private function defaultToArray($params)
    {
        $values = array();
        foreach(explode(',', $params) as $item){
            if(stripos($item, ':')){
                $args = explode(':',$item);
                $values[$args[0]] = $args[1];
            }
        }
        return $values;
    }
}