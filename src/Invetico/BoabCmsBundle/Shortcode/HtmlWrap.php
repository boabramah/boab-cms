<?php

namespace Invetico\BoabCmsBundle\Shortcode;

use Invetico\BoabCmsBundle\View\TemplateInterface;
use Invetico\BoabCmsBundle\Shortcode\BaseShortcode;

class HtmlWrap extends BaseShortcode
{
    protected $template;

    /**
     * @var string
     */
    protected $name = 'htmlwrap';
 
    /**
     * @var array
     */
    protected $attributes = [
        'view'=>'BoabCmsBundle:Block:page_header', 
        'background'=>'images/page-header.jpg',
        'images'=>''
    ];

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
        $atts['content'] = $content;
        $view = $this->template->load($atts['view']);
        return $view->render($atts);
        //return file_get_contents(__DIR__.'/view.php');
    }

}
