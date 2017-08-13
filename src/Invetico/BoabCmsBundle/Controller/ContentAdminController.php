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

class ContentAdminController extends AdminController implements InitializableControllerInterface, AdminControllerInterface
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
        $this->finder = $finder;
    }

    public function initialize()
    {
        $this->template->setTheme('novi');
    }

    /**
     * @Security("has_role('ROLE_USER')")
     */	
    public function indexAction(Request $request)
    {
        $view = $this->template->load('BoabCmsBundle:Admin:content_list.html.twig');
        $this->template->setTitle('Contents')
                     ->bind('page_header','Contents')
                     ->bind('content',$view);
        return $this->template;
    }


    public function AddAction(Request $request)
    {
        $type = $request->get('content_type');
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
        $form->action = $this->router->generate('admin_content_create', ['content_type' => strtolower($type)]);
        $form->content = $contentType->getEntity();

        $this->eventDispatcher->dispatch('content.form_render', new FormRenderEvent($form, $contentType->getEntity()));

        $this->template->setTitle('Create '.ucfirst($request->get('content_type')))
                     ->bind('page_header', 'Create '.ucfirst($request->get('content_type')))
                     ->bind('content', $form);

        return $this->template;
    }

    public function createAction(Request $request)
    {
        $typeId = $request->get('content_type');
        $contentType = $this->contentTypeManager->getType($typeId);
        $this->validation->validateRequest($request, $contentType->getValidator());

        $redirect = $this->router->generate('admin_content_add_type', ['content_type' => $typeId]);

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
    

    public function editAction(Request $request)
    {
        $pageId = (int) $request->get('id');

        $redirect = $this->router->generate('admin_content_edit', ['id' => $pageId]);
        $content = $this->contentRepository->findContentById($pageId);

        $contentType = $this->contentTypeManager->getType($content->getContentTypeId());

        if ('POST' === $request->getMethod()) {
            $validator = $contentType->getValidator($request->request->all());
            if (!$validator->isValid()) {
                $this->flash->setErrors($validator->getErrors());

                return $this->redirect($redirect);
            }
            $entity = $contentType->createEntity($request, $content);
            try {
                $this->contentService->update($entity, $request);
            } catch (\Exception $e) {
                $this->flash->setInfo($e->getMessage());

                return $this->redirect($redirect);
            }
            $this->flash->setSuccess(sprintf('%s updated successfully', $entity->getContentTypeLabel()));

            return $this->redirect($redirect);
        }

        $view = $this->template->load($contentType->getEditTemplate());
        $view->content = $content;
        $view->flash = $this->flash;
        $view->action = $redirect;
        $view->deleteContentThumbnail = $this->router->generate('delete_content_thumbnail',['id'=>$content->getId()]);

        $event = new FormRenderEvent($view, $content);
        $this->eventDispatcher->dispatch('content.form_render', $event);

        $this->template->setTitle('Edit Content')
                     ->bind('page_header', $content->getTitle())
                     ->bind('content', $event->getForm());

        return $this->template;
    }
    

    public function deleteAction(Request $request, $contentId)
    {
        $content = $this->contentRepository->findContentById($contentId);

        if (!$content) {
            throw new HttpException(403, 'Bad request! The content does not exist');
        }

        $event = new ContentDeletedEvent($content);
        $this->eventDispatcher->dispatch('content.delete', $event);

        $message = sprintf('Content <strong>%s</strong> deleted successfully', $content->getTitle());

        $this->entityManager->remove($content);
        $this->entityManager->flush();

        $normalizer = new SuccessResponseNormalizer([]);
        $normalizer->setMessage($message);

        return $normalizer;
    }
}
