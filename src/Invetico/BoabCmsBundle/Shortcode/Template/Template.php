<?php
namespace Invetico\BoabCmsBundle\Shortcode\Template;

use Invetico\BoabCmsBundle\Shortcode\BaseShortcode;
use Symfony\Component\Routing\RouterInterface;


class Template extends BaseShortcode
{
    private $router;
    private $template;

    /**
     * @var string
     */
    protected $name = 'template';
 
    /**
     * @var array
     */
    protected $attributes = [
        'block'=>'', 
        'cache'=>false
    ];

    public function __construct(RouterInterface $router, $template)
    {
        $this->router = $router;
        $this->template = $template;
    }
 
    /**
     * @param string|null $content
     * @param array $atts
     * @return string
     */
    public function handle($content = null, array $atts=[])
    {
        return $this->template->get($atts['block']);

        $view = $this->template->load($atts['view']);
        $view->generate = function($routeName, $param=[]){
            return $this->router->generate($routeName, $param);
        };
        return $view->render();
    }
}