<?php

namespace Invetico\BoabCmsBundle\Model;

use Invetico\BoabCmsBundle\Entity\AudioInterface;
use Invetico\BoabCmsBundle\Model\AbstractContentType;
use Symfony\Component\HttpFoundation\Request;
use Invetico\BoabCmsBundle\Entity\ContentInterface;

class AudioType extends AbstractContentType
{

    public function getTypeId()
    {
        return 'audio';
    }

    public function buildRouteParams(AudioInterface $content)
    {
        return ['slug' => $content->getSlug()];
    }

    public function getContentFromRoute(Request $request)
    {
        return $this->contentRepository->findContentBySlug($request->get('slug'));
    }

    public function createEntity(Request $request, ContentInterface $entity = null)
    {
        $entity =  parent::createEntity($request, $entity);
        $entity->setAuthor($request->get('audio_author'));

        return $entity;
    }

    public function getShowRouteName()
    {
        return 'audio_show';
    }

    public function getListRouteName()
    {
        return 'audio_list';
    }


    public function getContent(Request $request)
    {
        return $this->contentRepository->findContentBySlug($request->get('slug'));
    }


    public function getListView()
    {
        return 'BoabCmsBundle:Audio:audio_list';
    } 

    public function getNodeView()
    {
        return 'BoabCmsBundle:Audio:audio_show';
    }

    public function getListLayout()
    {
        return 'plain_tpl.html.twig';
    }

    public function getNodeLayout()
    {
        return 'page_tpl.html.twig';
    }	

    public function getContentTypeLabel()
    {
        return 'Audio';
    }
}
