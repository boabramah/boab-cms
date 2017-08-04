<?php

namespace Invetico\BoabCmsBundle\Shortcode\OtherContentType;

use Invetico\BoabCmsBundle\Shortcode\BaseShortcode;
use Invetico\BoabCmsBundle\View\TemplateInterface;
use Invetico\BoabCmsBundle\Repository\ContentRepositoryInterface;
use Symfony\Component\Routing\RouterInterface;


class OtherContentType extends BaseShortcode
{
    private $template;
    
    /**
     * @var string
     */
    protected $name = 'othercontent';

    protected $attributes = [];

    private $widget;

    private $router;

    private $contentTypeManager;

    private $contentRepository;
 

    public function __construct(TemplateInterface $template, RouterInterface $router, $typeManager, ContentRepositoryInterface $contentRepository)
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
        $widget = new \Invetico\BoabCmsBundle\Shortcodes\OtherContentType\Widget($atts);        
        $typeManager = $this->contentTypeManager->getType($widget->getContentTypeId());
        $collection = $this->contentRepository->findRelatedContentType($typeManager->getEntityClass(), $widget->getRecordLimit(), $widget->getExcludeIds());
        if(!$collection){
            return;
        }
        $view = $this->createView($widget, $typeManager);
        $view->collection = $collection;
        return $view->render();
    }     


    private function createView($widget, $typeManager)
    {
        $view = $this->template->load($widget->getView());
        $view->generate = function ($content) use ($typeManager) {
            return $this->router->generate($typeManager->getShowRouteName(),$typeManager->buildRouteParams($content));
        };
        return $view;
    }       

}
