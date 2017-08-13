<?php

namespace Invetico\BoabCmsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Finder\Finder;
use Invetico\BoabCmsBundle\Controller\BaseController;
use Invetico\BoabCmsBundle\Controller\PublicControllerInterface;
use Invetico\BoabCmsBundle\Controller\InitializableControllerInterface;
use Invetico\BoabCmsBundle\Repository\ContentRepositoryInterface;
use Invetico\BoabCmsBundle\Model\ContentTypeManager;
use Invetico\BoabCmsBundle\Entity\Content;
use Invetico\BoabCmsBundle\Event\NodeRenderEvent;
use Symfony\Component\Routing\RouterInterface;
use Invetico\BoabCmsBundle\Helper\ContentHelper ;
use Invetico\BoabCmsBundle\Entity\DynamicMenuNode;
use Invetico\BoabCmsBundle\Entity\ControllerAwareMenuNode;
use Invetico\BoabCmsBundle\Entity\NotFoundHttpMenuNode;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Invetico\BoabCmsBundle\Entity\ContentInterface;

class ContentController extends BaseController implements PublicControllerInterface
{
    private $contentRepository;
    private $contentTypeManager;
    private $finder;

    use ContentHelper;

    public function __construct
    (
        ContentRepositoryInterface $contentRepository,
        ContentTypeManager $contentTypeManager,
        RouterInterface $router,
        Finder $finder
    )
    {
        $this->contentRepository = $contentRepository;
        $this->contentTypeManager = $contentTypeManager;
        $this->router = $router;
        $this->finder = $finder;
    }

    public function initialize()
    {
        parent::initialize();
        $this->template->setTheme('kantua');
    }
    /**
     * Site root or home
     *
     * @param Request $request
     * @return void
     */
    public function indexAction(Request $request)
    {
        $this->template->setTitle('Home')
                ->bind('site_area', 'home')
                ->bind('featuredContent', $this->getFeaturedContent())
                ->setBlock('contentArea', 'home_layout.html.twig');

        return $this->template;
    }

    /**
     * Get List of contents
     *
     * @param Request $request
     * 
     * @param [type] $routeDocument
     * 
     * @return void
     */
    public function listAction(Request $request, $routeDocument = null)
    {
        $pageNumber = (int) $request->get('page');

        $entityClasses = [];
        $contentTypes = $routeDocument->getContentTypeId();
        foreach (explode(',', $contentTypes) as $type) {
            $typeManager = $this->contentTypeManager->getType($type);
            array_push($entityClasses, $typeManager->getEntityClass());
        }

        $collection = $this->contentRepository->findContentByEntities($entityClasses, $pageNumber);
 
        $pagingOption = [
            'page_total_rows' => count($collection),
            'page_number' => $pageNumber,
            'page_url' => $this->router->generate($routeDocument->getRouteName(), ['page' => $pageNumber])
        ];

        $view = $this->template->load($routeDocument->getTemplate());
        $view->pagination = $this->pagination->generate($pagingOption);
        $view->collection = $collection;
        $view->routeDocument = $routeDocument;

        $this->template->setTitle($routeDocument->getTitle())
                     ->bind('page_title', $routeDocument->getTitle())
                     ->bind('content', $view)
                     ->setBlock('contentArea','plain_tpl.html.twig');

        return $this->template;
    }


    public function showAction(Request $request, $routeDocument = null, $contentTemplate = null, $slug = null)
    {
        if ($routeDocument instanceof ControllerAwareMenuNode) {
            $contentNode = $this->contentRepository->findContentBySlug($slug);
            $typeManager = $this->contentTypeManager->getTypeByClass(get_class($contentNode));
            $contentTypes = $routeDocument->getContentTypeId();
            if (!in_array($typeManager->getContentTypeId(), explode(',', $contentTypes))) {
                throw new NotFoundHttpException('Content not found');
            }
        }

        if ($routeDocument instanceof DynamicMenuNode) {
            $typeManager = $this->contentTypeManager->getType($routeDocument->getContentTypeId());
            $contentNode = $typeManager->getContent($request);
        }

        if ($routeDocument instanceof NotFoundHttpMenuNode || !$contentNode) {
            throw new NotFoundHttpException("Page not found");
        }

        $view = $this->template->load($contentTemplate ? $contentTemplate : $typeManager->getNodeView());
        $event = new NodeRenderEvent($contentNode, $view);
        $this->eventDispatcher->dispatch('content.node_render', $event);
        $view = $event->getView();
        $view->content = $event->getNode();

        $layoutThemeBlock = $this->getLayoutThemeBlock($event->getNode(), $typeManager);

        $this->template->setTitle($contentNode->getTitle())
                     ->bind('page_title', $typeManager->getBlockTitle() ? $typeManager->getBlockTitle() : $contentNode->getTitle())
                     ->bind('content', $view)
                     ->setBlock('contentArea', $this->template->loadThemeBlock($layoutThemeBlock));
        
        return $this->template;
    }


    private function getLayoutThemeBlock($node, $typeManager)
    {
        if ($node->getLayoutType() == 1) {
            return 'plain_tpl.html.twig';
        }

        return $typeManager->getNodeLayout();
    }

    private function loadListViewForType($typeManager)
    {
        $view = $this->template->load($typeManager->getListView());
        $view->generate = $this->getGeneratorForType($typeManager);
        $view->flash = $this->flash;

        return $view;
    }

    private function getGeneratorForType($typeManager)
    {
        return function (ContentInterface $content, $routeKey = '') use ($typeManager) {
            return $this->router->generate($typeManager->getShowRouteName(), $typeManager->getShowRouteParams($content, $routeKey));
        };
    }

    /**
     * Featured content
     *
     * @return void
     */
    private function getFeaturedContent()
    {
        $content = $this->contentRepository->findFeaturedContent();
        if (!$content) {
            return;
        }
        $content->setTitle('Home');
        $view = $this->template->load('BoabCmsBundle:Widgets:featured_content.html.twig');
        $view->content = $content;
        $event = new NodeRenderEvent($content, $view);
        $this->eventDispatcher->dispatch('content.node_render', $event);
        
        return $event->getView();
    }
}
