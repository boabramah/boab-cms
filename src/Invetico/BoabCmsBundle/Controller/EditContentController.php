<?php

namespace Invetico\BoabCmsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Finder\Finder;
use Invetico\BoabCmsBundle\Controller\AdminController;
use Invetico\BoabCmsBundle\Controller\InitializableControllerInterface;
use Invetico\BoabCmsBundle\Service\ContentService;
use Invetico\UserBundle\Service\UserService;
use Invetico\BoabCmsBundle\Model\ContentTypeManager;
use Invetico\BoabCmsBundle\Entity\Content;
use Invetico\BoabCmsBundle\Repository\ContentRepositoryInterface;
use Invetico\BoabCmsBundle\Event\FormRenderEvent;
use Invetico\BoabCmsBundle\Helper\ContentHelper;
use Invetico\BoabCmsBundle\Event\ContentDeletedEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Utils\AjaxJsonResponse;
use Invetico\BoabCmsBundle\Controller\AdminControllerInterface;
use Invetico\ApiBundle\Normalizer\SuccessResponseNormalizer;
use Symfony\Component\HttpKernel\Exception\HttpException;

class EditContentController extends AdminController implements InitializableControllerInterface, AdminControllerInterface
{
    private $contentService;
    private $userService;
    private $contentTypeManager;
    private $contentRepository;
    private $finder;

    use ContentHelper;

    public function __Construct
    (
        ContentService $contentService,
        UserService $userService,
        ContentTypeManager $contentTypeManager,
        ContentRepositoryInterface $contentRepository,
        Finder $finder

    )
    {
        $this->contentService = $contentService;
        $this->userService = $userService;
        $this->contentTypeManager = $contentTypeManager;
        $this->contentRepository = $contentRepository;
    }

    public function initialize()
    {
        $this->template->setTheme('novi');
    }

    public function editAction(Request $request, $type, $contentId)
    {
        $contentType = $this->contentTypeManager->getType($type);
        $content = $this->contentRepository->findContentById($contentId);

        $view = $this->template->load($contentType->getEditTemplate());
        $view->content = $content;
        $view->action = $this->router->generate('edit_show_content', ['type' => $type, 'contentId' => $contentId]);
        $view->deleteContentThumbnail = $this->router->generate('delete_content_thumbnail',['id'=>$content->getId()]);

        $event = new FormRenderEvent($view, $content);
        $this->eventDispatcher->dispatch('content.form_render', $event);

        $this->template->setTitle('Edit Content')
                     ->bind('page_header', $content->getTitle())
                     ->bind('content', $event->getForm());

        return $this->template;
    }

    public function saveAction(Request $request, $type, $contentId)
    {
        $redirect = $this->router->generate('edit_show_content', ['type' => $type, 'contentId' => $contentId]);
        $contentType = $this->contentTypeManager->getType($type);

        $this->validation->validateRequest($request, $contentType->getValidator());
        if (!$this->validation->isValid()) {
            $this->flash->setErrors($this->validation->getErrors());
            $this->flash->setValues($request->request->all());

            return $this->redirect($redirect);
        }
        $content = $this->contentRepository->findContentById($contentId);

        $entity = $contentType->updateEntity($request, $content);

        try {
            //$this->eventDispatcher->dispatch();
            $this->update($entity);
        } catch (\Exception $e) {
            $this->flash->setInfo($e->getMessage());

            return $this->redirect($redirect);
        }
        $this->flash->setSuccess(sprintf('%s updated successfully', ucfirst($contentType->getTypeId())));

        return $this->redirect($redirect);
    }
}
