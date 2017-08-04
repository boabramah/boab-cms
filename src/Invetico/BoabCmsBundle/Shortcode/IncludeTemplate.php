<?php

namespace Invetico\BoabCmsBundle\Shortcode;

use Invetico\BoabCmsBundle\View\TemplateInterface;
use Invetico\BoabCmsBundle\Shortcode\BaseShortcode;

class IncludeTemplate extends BaseShortcode
{
    protected $template;

    /**
     * @var string
     */
    protected $name = 'include';
 
    /**
     * @var array
     */
    protected $attributes = ['template'=>''];

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
        $view = $this->template->load($atts['template']);
        return $view->render($atts);
    }

}
