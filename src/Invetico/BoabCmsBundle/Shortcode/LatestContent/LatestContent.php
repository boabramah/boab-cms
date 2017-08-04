<?php

namespace Invetico\BoabCmsBundle\Shortcode\LatestContent;

use Invetico\BoabCmsBundle\Shortcode\BaseShortcode;
use Invetico\BoabCmsBundle\View\TemplateInterface;
use Invetico\BoabCmsBundle\Repository\ContentRepositoryInterface;
use Invetico\BoabCmsBundle\Shortcodes\LatestContent\LatestItemType;
use Symfony\Component\Routing\RouterInterface;
use Invetico\BoabCmsBundle\Model\ContentTypeManagerInterface;

class LatestContent extends BaseShortcode
{
    private $template;
    
    /**
     * @var string
     */
    protected $name = 'latestcontent';

    protected $attributes = [];

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
        $widget = new LatestItemType($atts);

        $key = $widget->getContentTypeId();
        $typeManager = $this->contentTypeManager->getType($key);

        $collection = $this->contentRepository->findLatestContent($typeManager->getEntityClass(), $widget->getRecordLimit());
        if(!$collection){
            return;
            //throw new \InvalidArgumentException(sprintf('Invalid content id (%s) for the widget %s', $widget->getTermId(), get_class($widget)));            
        }

        $view = $this->createView($widget);
        $view->collection = $collection;
        $view->blockTitle = $widget->getTitle();
        return $view->render();
    }     


    private function createView($widget)
    {
        $class = $widget->getContentTypeId();
        $typeManager = $this->contentTypeManager->getType($class);
        $view = $this->template->load($widget->getListView());
        $view->generate = function ($content) use ($typeManager) {
            return $this->router->generate($typeManager->getShowRouteName(),$typeManager->buildRouteParams($content));
        };
        return $view;
    }       

}
