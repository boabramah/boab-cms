<?php

namespace Invetico\BoabCmsBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\RouterInterface;
use Invetico\BoabCmsBundle\View\Template;
use Invetico\BoabCmsBundle\Entity\ContentInterface;
use Invetico\BoabCmsBundle\Event\FormRenderEvent;
use Invetico\BoabCmsBundle\Repository\PhotoRepositoryInterface;
use Invetico\BoabCmsBundle\View\Form\EditFormInterface;


class PhotoGalleryListener
{
    private $template;
    private $router;
    private $photoRepository;
    private $request;

    public function __construct(Template $template, RouterInterface $router, PhotoRepositoryInterface $photoRepository)
    {
        $this->template = $template;
        $this->router = $router;
        $this->photoRepository = $photoRepository;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $this->request = $request = $event->getRequest();
    }    


    public function onContentNodeRender($event)
    {
        $currentEntity = $event->getNode();
        $nodeView = $event->getView();
        if($currentEntity instanceof ContentInterface){
           // $nodeView->contentGallery = $this->getContentGalleryWidget($currentEntity);
            //die('sffdsdf');
        }

        $event->setView($nodeView);
    }

    public function onContentFormRender(FormRenderEvent $event)
    {
        $entity = $event->getEntity();
        $view = $event->getForm();
        if($entity instanceof ContentInterface && $view instanceof EditFormInterface){
            $view->photoUploadUrl = $this->router->generate('photo_upload',['contentId'=>$entity->getId()]);
            $view->albumPhotos = $this->getAlbumPhotos($entity);
        }        
    } 

    private function getAlbumPhotos($content)
    {
        $collection = $this->photoRepository->getPhotoByContent($content->getId());
        $view = $this->template->load('BoabCmsBundle:Admin:content_photos');
        $view->collection = $collection;
        $view->deletePhotoUrl = function($photo){
            return $this->router->generate('photo_delete',['photoId'=>$photo->getId()],true);
        };
        $view->generateEditUrl = function($photo){
            //return $this->router->generate('photo_admin_edit',['id'=>$photo->getId()]);
        };        
        return $view;        
    }


    private function getContentGalleryWidget($entity)
    {
        $view = $this->template->load('BoabCmsBundle:Widgets:content_gallery');
        $view->photos = $entity->getPhotos();
        $view->thumbnail = $entity->getThumbnailUrlPath();
        $view->generateAsset = function($asset){
            return $this->request->getBasePath().'/'. $asset;
         }; 
        return $view;
    }

}
