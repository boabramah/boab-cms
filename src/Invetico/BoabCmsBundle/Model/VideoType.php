<?php

namespace Invetico\BoabCmsBundle\Model;

use Invetico\BoabCmsBundle\Entity\Video;
use Symfony\Component\HttpFoundation\Request;
use Invetico\BoabCmsBundle\Model\AbstractContentType;
use Invetico\BoabCmsBundle\Entity\ContentInterface;

class VideoType extends AbstractContentType
{
    public function getTypeId()
    {
        return 'video';
    }

    public function createEntity(Request $request, ContentInterface $entity = null)
    {
        $entity =  parent::createEntity($request, $entity);
        $entity->setYoutubeVideoId($request->get('youtube_video_id'));

        return $entity;
    }

    public function getValidator(array $data = [])
    {
        return new \Invetico\BoabCmsBundle\Validation\Form\Video($data);
    }

    public function buildRouteParams(Video $content)
    {
        return ['slug' => $content->getSlug()];
    }

    public function getListView()
    {
        return 'BoabCmsBundle:Video:list_videos';
    }

    public function getListLayout()
    {
        return 'plain_tpl.html.twig';
    }     

    public function getNodeLayout()
    {
        return 'page_tpl.html.twig';
    }

    public function getNodeView()
    {
        return 'BoabCmsBundle:Video:video_player';
    }

    public function getShowRouteName()
    {
        return 'video_show';
    }

    public function getListRouteName($request)
    {
        return 'takes_season_show';
    }

    public function getRouteParams($routeName, $request)
    {
        return ['season' => $request->get('season')];
    }

    public function getContentRouteParams($routeKey, $content)
    {
        switch ($routeKey) {
            case 'video_show':
                return ['slug' => $content->getSlug()];
                break;

            default:
                return [];
                break;
        }
    }
    
    public function getContentTypeId()
    {
        return 'video';
    }

    public function getContentTypeLabel()
    {
        return 'Video';
    }

}
