<?php

namespace Invetico\BoabCmsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Invetico\BoabCmsBundle\Controller\AdminController;
use Invetico\BoabCmsBundle\Model\ContentTypeManager;
use Invetico\BoabCmsBundle\Repository\ContentRepositoryInterface;
use Invetico\BoabCmsBundle\Event\FormRenderEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Invetico\BoabCmsBundle\Controller\AdminControllerInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Invetico\BoabCmsBundle\Events;
use Invetico\BoabCmsBundle\Event\ContentPreUpdateEvent;

class EditContentController extends AdminController implements AdminControllerInterface
{
    private $contentTypeManager;
    private $contentRepository;

    public function __Construct(ContentTypeManager $contentTypeManager, ContentRepositoryInterface $contentRepository)
    {
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

        $event = new ContentPreUpdateEvent($content);

        try {
            $this->eventDispatcher->dispatch(Events::CONTENT_PRE_UPDATE, $event);
            $this->update($event->getContent());
        } catch (\Exception $e) {
            $this->flash->setInfo($e->getMessage());

            return $this->redirect($redirect);
        }
        $this->flash->setSuccess(sprintf('%s updated successfully', ucfirst($contentType->getTypeId())));

        return $this->redirect($redirect);
    }
}
