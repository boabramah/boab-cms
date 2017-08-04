<?php

namespace Invetico\BoabCmsBundle\Shortcode\Contents;

use Invetico\BoabCmsBundle\Shortcode\BaseShortcode;
use Invetico\BoabCmsBundle\View\TemplateInterface;
use Invetico\BoabCmsBundle\Repository\ContentRepositoryInterface;
use Symfony\Component\Routing\RouterInterface;
use Invetico\BoabCmsBundle\Model\ContentTypeManagerInterface;

class Contents extends BaseShortcode
{
    private $template;
    
    /**
     * @var string
     */
    protected $name = 'contents';

    protected $attributes = ['types'=>'','limit'=>3,'template'=>''];

    private $widget;

    private $router;

    private $contentTypeManager;

    private $contentRepository;
 

    public function __construct
    (
        TemplateInterface $template, 
        RouterInterface $router, 
        ContentTypeManagerInterface $typeManager, 
        ContentRepositoryInterface $contentRepository
    )
    {
        
        $this->template = $template;
        $this->router = $router;
        $this->contentTypeManager = $typeManager;
        $this->contentRepository = $contentRepository;
    }
 
    /**
     * @param string|null $content
     * @param array $atts
     * @return string
     */
    public function handle($content = null, array $atts=[])
    {
        //$widget = new LatestItemType($atts);
        $entityClasses = [];
        $contentTypes = $atts['types'];
        foreach(explode(',',$contentTypes) as $type){
            $typeManager = $this->contentTypeManager->getType($type);
            array_push($entityClasses, $typeManager->getEntityClass());
        }
        $collection = $this->contentRepository->findContentByEntitiesWidget($entityClasses, $atts['limit']);
        if(!$collection){
            return;
        }

        $view = $this->createView($atts['template']);
        $view->collection = $collection;
        return $view->render();
    }     


    private function createView($view)
    {
        $view = $this->template->load($view);
        $view->generate = function ($content){
            return $this->router->generate('posts_show',['slug'=>$content->getSlug()]);
        };
        return $view;
    }       

}
