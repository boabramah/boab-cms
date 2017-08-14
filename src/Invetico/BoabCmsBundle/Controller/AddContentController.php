<?php

namespace Invetico\BoabCmsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Invetico\BoabCmsBundle\Controller\AdminController;
use Invetico\BoabCmsBundle\Controller\InitializableControllerInterface;
use Invetico\BoabCmsBundle\Model\ContentTypeManager;
use Invetico\BoabCmsBundle\Repository\ContentRepositoryInterface;
use Invetico\BoabCmsBundle\Event\FormRenderEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Invetico\BoabCmsBundle\Controller\AdminControllerInterface;

class AddContentController extends AdminController implements AdminControllerInterface
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

    public function AddAction(Request $request, $type = null)
    {
        if (!$type) {
            $view = $this->template->load('BoabCmsBundle:Admin:select_content_type.html.twig');
            $view->contentTypes = $this->contentTypeManager->getContentTypes();
            $this->template->setTitle('Select Content Type')
                    ->bind('page_header', 'Select Content Type')
                    ->bind('content', $view);

            return $this->template;
        }

        $contentType = $this->contentTypeManager->getType($type);

        $form = $this->template->load($contentType->getAddTemplate());
        $form->action = $this->router->generate('admin_content_save', ['type' => $type]);
        $form->content = $contentType->getEntity();

        $this->eventDispatcher->dispatch('content.form_render', new FormRenderEvent($form, $contentType->getEntity()));

        $this->template->setTitle('Create '.ucfirst($request->get('content_type')))
                     ->bind('page_header', 'Create '.ucfirst($request->get('content_type')))
                     ->bind('content', $form);

        return $this->template;
    }

    public function saveAction(Request $request, $type)
    {
        $redirect = $this->router->generate('admin_content_add_type', ['type' => $type]);
        $contentType = $this->contentTypeManager->getType($type);

        $this->validation->validateRequest($request, $contentType->getValidator());
        if (!$this->validation->isValid()) {
            $this->flash->setErrors($this->validation->getErrors());
            $this->flash->setValues($request->request->all());

            return $this->redirect($redirect);
        }

        $entity = $contentType->createEntity($request, null);

        try {
            $results = $this->contentService->create($entity, $request);
        } catch (\Exception $e) {
            $this->flash->setInfo($e->getMessage());

            return $this->redirect($redirect);
        }
        $this->flash->setSuccess(sprintf('%s <strong>%s</strong> created successfully', $entity->getContentTypeLabel(), $entity->getTitle()));

        return $this->redirect($redirect);
    }

}
