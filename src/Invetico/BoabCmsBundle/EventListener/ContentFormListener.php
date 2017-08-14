<?php

namespace Invetico\BoabCmsBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Routing\RouterInterface;
use Invetico\BoabCmsBundle\View\Template;
use Invetico\BoabCmsBundle\Entity\House;
use Invetico\BoabCmsBundle\Helper\ContentHelper;
use Symfony\Component\Finder\Finder;
use Invetico\BoabCmsBundle\Repository\ContentRepositoryInterface;
use Invetico\PageBundle\Entity\PageInterface;
use Invetico\BoabCmsBundle\Entity\ParentableInterface;

class ContentFormListener
{
    private $contentRepository;
    private $template;
    private $router;
    private $finder;

    use ContentHelper;

    public function __construct(ContentRepositoryInterface $contentRepository, Template $template, RouterInterface $router, Finder $finder)
    {
        $this->contentRepository = $contentRepository;
        $this->template = $template;
        $this->router = $router;
        $this->finder = $finder;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
    }

    public function onContentFormRender($event)
    {
        $content = $event->getEntity();
        $view = $event->getForm();

        if ($content instanceof ParentableInterface) {
            $pages = $this->contentRepository->findAllContentByType('Invetico\BoabCmsBundle\Entity\Page');
            $view->pagesOptions = $this->generateOptionList($pages, $content);
        }

        if ($content->hasThumbnail()) {
            $view->uploadedAttachmentImage = $this->getUploadedImageForContent($content);
        }
        $event->setForm($view);
    }

    private function generateOptionList($pages, $content)
    {
        $option = '';
        foreach ($pages as $page) {
            $option .= '<option value="'.$page->getId().'"';
            if ($page->getId() === $content->getParentId()) {
                $option .= ' selected = "selected"';
            }
            $option .= '>'.$page->getTitle().'</option>';
        }

        return $option;
    }

    private function getImageUploadArea($content)
    {
        $view =  $this->template->load('BoabCmsBundle:Admin:upload_file');
        $thumbnails = $this->getContentUploadedImages($content);
        $view->thumbnails = $thumbnails;
        $view->imageUploadUrl = $this->router->generate('content_image_upload',['content_id'=>$content->getId()]);
        $view->setCoverLink = function ($thumbnail) use ($content) {
            return $this->router->generate('set_content_cover',['image'=>$this->getPathFromImage($thumbnail)]);
        };
        $view->imageDeleteLink = function ($thumbnail) {
            return $this->router->generate('delete_content_image',['image'=>$this->getPathFromImage($thumbnail)]);
        };

        return $view;
    }

    private function getUploadedImageForContent($content)
    {
        $view =  $this->template->load('BoabCmsBundle:Admin:thumbnail_upload_box.html.twig');
        $view->content = $content;

        return $view;
    }

    private function getPathFromImage($thumbnail)
    {
        $parts = explode('/', $thumbnail);
        $parts = array_slice($parts, -2);

        return implode('.',$parts);
    }

}
