<?php

namespace Invetico\BoabCmsBundle\Shortcode\Pages;

use Invetico\BoabCmsBundle\Shortcode\BaseShortcode;
use Invetico\BoabCmsBundle\View\TemplateInterface;
use Invetico\BoabCmsBundle\Repository\ContentRepositoryInterface;
use Symfony\Component\Routing\RouterInterface;

class Pages extends BaseShortcode
{   
    /**
     * @var string
     */
    protected $name = 'pages';

    protected $attributes = [
        'type'=>'page',
        'template'=>'',
        'limit' =>0,
        'date_order'=>'desc',
        'parentid'=>null
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
        $typeManager = $this->contentTypeManager->getType($atts['type']);
        $collection = $this->contentRepository->findContentsByParentId($atts['parentid'], $atts['limit'], $atts['date_order']);
        if(!$collection){
            throw new \InvalidArgumentException(sprintf('CHILDPAGE SHORTCODE! No child pages for the selected parent id (%s)', $atts['parentId']));            
        }
        $view = $this->createView($atts, $typeManager);
        $view->collection = $collection;
        return $view->render();
    } 


    private function createView($atts, $typeManager)
    {
        $view = $this->template->load($atts['template']);
        $view->generate = function ($content) use ($typeManager) {
            return $this->router->generate($content->getMenu()->getRouteName());
        };
        return $view;
    }       

}
