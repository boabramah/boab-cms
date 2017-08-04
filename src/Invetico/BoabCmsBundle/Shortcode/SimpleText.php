<?php

namespace Invetico\BoabCmsBundle\Shortcode;

use Invetico\BoabCmsBundle\Shortcode\BaseShortcode;

class SimpleText extends BaseShortcode
{
    protected $environment;

    /**
     * @var string
     */
    protected $name = 'simpletext';
 
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
        $id = $atts['id'];
        $hash = md5($id);

        $cacheDir = sprintf(dirname(__DIR__) . '/../../../app/cache/%s/sitecache',$this->environment);
        
        if(!is_dir($cacheDir)){
            mkdir($cacheDir, 0755, true);
        }
        
        $cacheFile = sprintf('%s/%s.txt', $cacheDir, $hash); 
        if(!file_exists($cacheFile)){
            file_put_contents($cacheFile, $content);
        }
        return file_get_contents($cacheFile);
    }
}