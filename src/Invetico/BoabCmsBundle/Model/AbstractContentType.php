<?php

namespace Invetico\BoabCmsBundle\Model;

use Symfony\Component\HttpFoundation\Request;
use Invetico\BoabCmsBundle\Entity\ContentInterface;
use Invetico\BoabCmsBundle\Entity\Content;
use Invetico\BoabCmsBundle\Repository\ContentRepositoryInterface;
use Invetico\BoabCmsBundle\Util\UtilCommon;

abstract class AbstractContentType implements ContentTypeInterface
{
    protected $contentRepository;
    protected $entity;
    protected $addTemplate;
    protected $editTemplate;
    protected $showTemplate;
    protected $listTemplate;
    protected $showLayout;
    protected $listLayout;
    protected $description;
    protected $validator;

    use UtilCommon;

    public function setContenRepository(ContentRepositoryInterface $contentRepository)
    {
        $this->contentRepository = $contentRepository;
    }
    
    public function setConfiguration(array $configs = [])
    {
        $this->entity = $configs['entity'];
        $this->addTemplate = $configs['add_template'];
        $this->editTemplate = $configs['edit_template'];
        $this->showTemplate = $configs['show_template'];
        $this->listTemplate = $configs['list_template'];
        $this->description = $configs['description'];
        $this->validator = $configs['form_validator'];
    }

    public function getEntity()
    {
        return new $this->entity;
    }

    public function setAddTemplate($template)
    {
        $this->addTemplate = $template;
    }

    public function getAddTemplate()
    {
        return $this->addTemplate;
    }

    public function setEditTemplate($template)
    {
        $this->editTemplate = $template;
    }

    public function getEditTemplate()
    {
        return $this->editTemplate;
    }

    public function getShowTemplate()
    {
        return $this->showTemplate;
    }

    public function setListLayout($template)
    {
        $this->listLayout = $template;
    }

    public function setShowLayout($template)
    {
        $this->showLayout = $template;
    }

    public function getValidator()
    {
        $ref = new \ReflectionClass($this->validator);
        return $ref->newInstanceArgs();
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getEntityClass()
    {
        $reflect = new \ReflectionClass($this->getEntity());
        return $reflect->getNamespaceName().'\\'.$reflect->getShortName();
    }

    public function getContent(Request $request)
    {
        $route = $request->get('routeDocument');
 
        return $this->contentRepository->findContentByRouteId((int) $route->getId());
    }

    public function getContentByType($request, $pageNumber)
    {
        return $this->contentRepository->findPublishedContentByType($this->getEntityClass(), $pageNumber);
    }

    public function createEntity(Request $request)
    {
        return $this->setContentData($request, $this->getEntity());
    }

    public function updateEntity(Request $request, ContentInterface $entity)
    {
        return $this->setContentData($request, $entity);
    }

    public function getBlockTitle()
    {
        return null;
    }

    public function getNodeLayout()
    {
        return 'page_tpl.html.twig';
    }

    public function getListLayout()
    {
        return 'page_tpl.html.twig';
    }

    public function getListView()
    {
        return 'BoabCmsBundle:Admin:list_content';
    }


    public function getRouteParams($routeName, $request)
    {
        return [];
    }

    public function getShowRouteParams(ContentInterface $content)
    {
        return ['slug' => $content->getSlug()];
    }

    private function setContentData(Request $request, ContentInterface $entity)
    {
        $entity->setTitle($request->get('page_title'));
        $entity->setSlug($this->slugify($request->get('page_title')));
        $entity->setSummary($request->get('page_summary'));
        $entity->setBody($request->get('page_body'));
        $entity->setStatus($request->get('page_status'));
        $entity->setPromoted($request->get('content_promoted'));
        $entity->setLayoutType($request->get('layout_type', 2));
        $entity->setIsFeatured($request->get('is_featured'));
        $entity->setMetaKeywords($request->get('meta_keywords'));
        $entity->setMetaDescription($request->get('meta_description'));

        if (Content::STATUS_PUBLISHED === $entity->getStatus()) {
            $entity->setDatePublished($request->get('published_date'));
        }

        return $entity;
    }

}
