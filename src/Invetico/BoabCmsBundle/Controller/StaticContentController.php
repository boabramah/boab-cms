<?php

namespace Invetico\BoabCmsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Invetico\BoabCmsBundle\Controller\BaseController;
use Invetico\BoabCmsBundle\Controller\InitializableControllerInterface;
use Invetico\BoabCmsBundle\Repository\ContentRepositoryInterface;
use Invetico\BoabCmsBundle\Model\ContentTypeManager;
use Symfony\Cmf\Component\Routing\ChainRouter;
use Invetico\BoabCmsBundle\Event\ContactFormSubmitedEvent;
use Invetico\PageBundle\Form\Type\ContactType;

class StaticContentController extends BaseController implements InitializableControllerInterface
{
    private $contentRepository;
    private $contentTypeManager;
    protected $router;

    public function __construct
    (
        ContentRepositoryInterface $contentRepository,
        ContentTypeManager $contentTypeManager,
        ChainRouter $router
    )
    {
        $this->contentRepository = $contentRepository;
        $this->contentTypeManager = $contentTypeManager;
        $this->router = $router;
    }

    public function initialize()
    {
        $this->template->setTheme('kantua');
        //$this->template->setBase();
    }


}
