<?php
/* Currency.php */
namespace Invetico\BoabCmsBundle\Shortcode\FeaturedContent;

use Invetico\BoabCmsBundle\Shortcode\BaseShortcode;
use Invetico\BoabCmsBundle\View\TemplateInterface;
use Invetico\BoabCmsBundle\Repository\ContentRepositoryInterface;
use Symfony\Component\Routing\RouterInterface;
/**
 * Generate Currency symbols
 * @package Maiorano\Shortcodes\Library
 */
class FeaturedContent extends BaseShortcode
{
    private $template;
    
    /**
     * @var string
     */
    protected $name = 'featuredcontent';

    protected $attributes = [];

    private $widget;

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
        $widget = new \Invetico\BoabCmsBundle\Shortcodes\FeaturedContent\EntityWidget($atts);

        $key = $widget->getContentTypeId();
        $typeManager = $this->contentTypeManager->getType($key);

        $content = $this->contentRepository->findFeaturedContentType($typeManager->getEntityClass(), 1);
        if(!$content){
            return;
            //throw new \InvalidArgumentException(sprintf('Invalid content id (%s) for the widget %s', $widget->getTermId(), get_class($widget)));            
        }

        $view = $this->createView($widget);
        $view->content = $content;
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
