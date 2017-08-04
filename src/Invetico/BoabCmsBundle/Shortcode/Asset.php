<?php

namespace Invetico\BoabCmsBundle\Shortcode;

use Invetico\BoabCmsBundle\Shortcode\BaseShortcode;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class Asset extends BaseShortcode
{
    private $router;

    private $appEnv;
    
    /**
     * @var string
     */
    protected $name = 'asset';

    protected $attributes = [];

    private $exclude= ['app_dev.php','app.php'];

    private $request;
 

    public function __construct(RequestStack $requestStack, RouterInterface $router, $appEnv)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->router = $router;
        $this->appEnv = $appEnv;
    }
 
    /**
     * @param string|null $content
     * @param array $atts
     * @return string
     */
    public function handle($content = null, array $atts=[])
    {
        $baseUrl = $this->router->generate('site_root',[],true);
        return $this->request->getSchemeAndHttpHost().$this->getCleanBaseUrl($baseUrl).$atts['path'];

    } 

    private function getCleanBaseUrl($url)
    {
        foreach($this->exclude as $key => $delimiter){
            $position = strpos($url, $delimiter);
            if($position !== false){
                return substr($url, 0, $position);
            }
        }
        return $url;
    }

}
