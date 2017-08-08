<?php

namespace Invetico\BoabCmsBundle\Model;

use Symfony\Component\HttpFoundation\Request;
use Invetico\BoabCmsBundle\Entity\ContentInterface;
use Invetico\BoabCmsBundle\Entity\Content;

abstract class AbstractContentType implements ContentTypeInterface
{
    protected $contentRepository;
    protected $template;
    protected $request;

    public function setTemplate($template)
    {
        $this->template = $template;
    }

    public function setRequest($request)
    {
        $this->request = $request;
    }

    public function setContenRepository($contentRepository)
    {
        $this->contentRepository = $contentRepository;
    }

    public function getEntityClass()
    {
        $reflect = new \ReflectionClass($this->getEntity());
        return $reflect->getNamespaceName().'\\'.$reflect->getShortName();
    }

    public function getContentFromRoute(Request $request)
    {
        $route = $request->attributes->get('routeDocument');
        return $this->contentRepository->findContentByRouteId((int) $route->getId());
    }

    public function getContentByRoute(Request $request)
    {
        $route = $request->attributes->get('routeDocument');
        return $this->contentRepository->findContentByRouteId((int) $route->getId());
    }

    public function getContent(Request $request)
    {
        $route = $request->get('routeDocument');
        return $this->contentRepository->findContentByRouteId((int) $route->getId());
    }

    public function createEntity(Request $request, $entity)
    {
        $entity = !$entity ? $this->getEntity() : $entity;
        $entity->setTitle($request->get('page_title'));
        $entity->setSlug(clean_url($request->get('page_title')));
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

    public function getBlockTitle()
    {
        return null;
    }

    public function getContentTypeDescription()
    {
        return $this->getEntity()->getContentTypeDescription();
    }

    public function getContentTypeId()
    {
        return $this->getEntity()->getContentTypeId();
    }

    public function getAddTemplate()
    {
        return 'BoabCmsBundle:Admin:add_page.html.twig';
    }

    public function getEditTemplate()
    {
        return 'BoabCmsBundle:Admin:edit_page';
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

    public function getNodeView()
    {
        return 'BoabCmsBundle:Page:page_show.html.twig';
    }

    public function getContentByType($request, $pageNumber)
    {
        return $this->contentRepository->findPublishedContentByType($this->getEntityClass(), $pageNumber);
    }

    public function getRouteParams($routeName, $request)
    {
        return [];
    }

    public function getShowRouteParams(ContentInterface $content)
    {
        return ['slug'=>$content->getSlug()];
    }

}
