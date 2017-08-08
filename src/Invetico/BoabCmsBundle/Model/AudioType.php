<?php

namespace Invetico\BoabCmsBundle\Model;

use Invetico\BoabCmsBundle\Entity\AudioInterface;
use Invetico\BoabCmsBundle\Model\AbstractContentType;
use Symfony\Component\HttpFoundation\Request;

class AudioType extends AbstractContentType
{
    
    public function getEntity()
    {
        return new \Invetico\BoabCmsBundle\Entity\Audio();
    }

    public function getValidator(array $data=[])
    {
        return new \Invetico\BoabCmsBundle\Validation\Form\Audio($data);
    }	

    public function buildRouteParams(AudioInterface $content)
    {
        return ['slug' => $content->getSlug()];
    }

    public function getContentFromRoute(Request $request)
    {
        return $this->contentRepository->findContentBySlug($request->get('slug'));
    }		

    public function createEntity(Request $request, $entity=null)
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

    public function getContentRouteParams($routeKey, $content)
    {
        switch ($routeKey) {
            case 'audio_show':
                return ['slug' => $content->getSlug()];
                break;

            default:
                return [];
                break;
        }
    }

    public function getContent(Request $request)
    {
        return $this->contentRepository->findContentBySlug($request->get('slug'));
    } 

    public function getAddTemplate()
    {
        return 'BoabCmsBundle:Audio:add_audio.html.twig';
    }

    public function getEditTemplate()
    {
        return 'BoabCmsBundle:Audio:edit_audio';
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
}