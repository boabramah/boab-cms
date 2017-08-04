<?php

namespace Invetico\BoabCmsBundle\Shortcode\HtmlEditor;

use Invetico\BoabCmsBundle\Shortcode\BaseShortcode;
use Invetico\BoabCmsBundle\View\TemplateInterface;
use Invetico\BoabCmsBundle\Repository\ContentRepositoryInterface;
use Symfony\Component\Routing\RouterInterface;


class HtmlEditor extends BaseShortcode
{
    private $template;
    
    /**
     * @var string
     */
    protected $name = 'htmleditor';

    protected $attributes = [];
 

    public function __construct(TemplateInterface $template)
    {
        $this->template = $template;
    }
 
    /**
     * @param string|null $content
     * @param array $atts
     * @return string
     */
    public function handle($content = null, array $atts=[])
    {
        $widget = new \Invetico\BoabCmsBundle\Shortcodes\HtmlEditor\Widget($atts);        
        $view = $this->template->load($widget->getview());
        $view->content = $content;

        return $view->render();
    }     
       

}
