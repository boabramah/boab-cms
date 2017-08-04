<?php

namespace Invetico\BoabCmsBundle\Model;

use Symfony\Component\HttpFoundation\Request;
use Invetico\BoabCmsBundle\Entity\Page;
use Invetico\BoabCmsBundle\Model\AbstractContentType;

class PageType extends AbstractContentType
{

    public function getValidator(array $data=[])
    {
        return new \Invetico\BoabCmsBundle\Validation\Form\Page($data);
    }

    public function createEntity(Request $request, $entity=null)
    {
        $entity = (null === $entity) ? $this->getEntity() : $entity;
        $entity->setParentId($request->get('page_parent'));

        return parent::createEntity($request, $entity);
    }

    public function getEntity()
    {
        return new Page();
    }

}
