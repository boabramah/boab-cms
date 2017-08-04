<?php

namespace Invetico\BoabCmsBundle\Shortcode\ChildPages;

use Invetico\BoabCmsBundle\Shortcode\BaseShortcode;
use Invetico\BoabCmsBundle\View\TemplateInterface;
use Invetico\BoabCmsBundle\Repository\ContentRepositoryInterface;
use Symfony\Component\Routing\RouterInterface;

class ChildPages extends BaseShortcode
{   
    /**
     * @var string
     */
    protected $name = 'childpages';

    protected $attributes = [
        'contenttypeid'=>'',
        'view'=>'',
        'records' =>0,
        'date_order'=>'desc',
        'parentid'=>0
    ];

    private $template;

    private $router;

    private $contentTypeManager;

    private $contentRepository;
 

    public function __construct(TemplateInterface $template, RouterInterface $router,$typeManager, ContentRepositoryInterface $contentRepository)
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
        $widget = new Widget($atts);
        $typeManager = $this->contentTypeManager->getType($widget->getContentTypeId());
        $collection = $this->contentRepository->findContentsByParentId($widget->getParentPageId(), $widget->getRecordLimit(), $widget->getDateOrder());
        if(!$collection){
            throw new \InvalidArgumentException(sprintf('CHILDPAGE SHORTCODE! No child pages for the selected parent id (%s)', $widget->getParentPageId()));            
        }
        $view = $this->createView($widget);
        $view->collection = $collection;
        return $view->render();
    } 


    private function createView($widget)
    {
        $class = $widget->getContentTypeId();
        $typeManager = $this->contentTypeManager->getType($class);
        $view = $this->template->load($widget->getListView());
        $view->generate = function ($content) use ($typeManager) {
            //die($content->getMenu()->getRouteName());
            return $this->router->generate($content->getMenu()->getRouteName());
        };
        return $view;
    }       

}
