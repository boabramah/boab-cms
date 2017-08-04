<?php

namespace Invetico\BoabCmsBundle\Shortcode\CommentBox;

use Invetico\BoabCmsBundle\Shortcode\BaseShortcode;

class CommentBox extends BaseShortcode
{
    protected $environment;

    /**
     * @var string
     */
    protected $name = 'commentbox';
 
    /**
     * @var array
     */
    protected $attributes = array('id'=>'');

    public function __construct($environment)
    {
        $this->environment = $environment;
    }
 
    /**
     * @param string|null $content
     * @param array $atts
     * @return string
     */
    public function handle($content = null, array $atts=[])
    {
    	return file_get_contents(__DIR__.'/view.php');
    }

}
