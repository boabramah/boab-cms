<?php

namespace Invetico\BoabCmsBundle\Model;

use Symfony\Component\HttpFoundation\Request;
use Invetico\BoabCmsBundle\Entity\Page;
use Invetico\BoabCmsBundle\Entity\PageInterface;
use Invetico\BoabCmsBundle\Model\AbstractContentType;
use Invetico\BoabCmsBundle\Entity\ContentInterface;

class PageType extends AbstractContentType
{
    public function getTypeId()
    {
        return 'page';
    }

    public function createEntity(Request $request, ContentInterface $entity = null)
    {
        $entity = parent::createEntity($request, $entity);
        $entity->setParentId($request->get('page_parent'));

        return $entity;
    }

    public function updateEntity(Request $request, ContentInterface $entity)
    {
        $entity = parent::updateEntity($request, $entity);
        $entity->setParentId($request->get('page_parent'));

        return $entity;
    }

    public function getContentTypeId()
    {
        return 'page';
    }

    public function getContentTypeLabel()
    {
        return 'Page';
    }

}
