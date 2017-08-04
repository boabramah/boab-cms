<?php

namespace Invetico\BoabCmsBundle\Shortcode;

use Invetico\BoabCmsBundle\Shortcode\BaseShortcode;
use Bundle\GalleryBundle\Library\PhotoGallery;
use Invetico\BoabCmsBundle\View\TemplateInterface;
use Invetico\WidgetBundle\Model\Type\WidgetInterface;

class SubPages extends BaseShortcode
{
    private $template;
    
    /**
     * @var string
     */
    protected $name = 'subpages';

    protected $attributes = [];

    private $widget;

    private $router;

    private $contentTypeManager;

    private $contentRepository;
 

    public function __construct(TemplateInterface $template, $router, $typeManager, $contentRepository)
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
        $widget = new \Invetico\WidgetBundle\Widget\PageParentalWidget($atts);

        $collection = $this->contentRepository->findContentsByParentId($widget->getPageId(), $widget->getRecordLimit());
        if(!$collection){
            throw new \InvalidArgumentException(sprintf('Invalid content id (%s) for the widget %s', $widget->getPageId(), get_class($widget)));            
        }

        $view = $this->createView($widget);
        $view->collection = $collection;
        return $view->render();
    }     


    private function createView(WidgetInterface $widget)
    {
        $class = $widget->getContentType();
        $typeManager = $this->contentTypeManager->getTypeByClass($class);
        $view = $this->template->load($widget->getListView());
        $view->generate = function ($content) use ($typeManager) {
            return $this->router->generate($typeManager->getShowRouteName(),$typeManager->buildRouteParams($content));
        };
        return $view;
    }    

}