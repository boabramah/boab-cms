<?php

namespace Invetico\BoabCmsBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\RouterInterface;
use Invetico\BoabCmsBundle\View\Template;
use Invetico\BoabCmsBundle\Model\SeoInterface;

class SeoListener
{
	private $template;
	private $router;
	private $request;

	public function __construct(Template $template,RouterInterface $router)
	{
		$this->template = $template;
		$this->router = $router;
	}

	public function onKernelRequest(GetResponseEvent $event)
	{
		//$this->request = 
		$this->request = $request = $event->getRequest();

		if (!$event->getRequestType() === HttpKernelInterface::MASTER_REQUEST) {
			return;
		}
		if ('/' !== $request->getPathInfo()) {
			
		}

	}

	public function onContentNodeRender($event)
	{
		$entity = $event->getNode();
		$nodeView = $event->getView();
		if(!$entity instanceof SeoInterface){
			return;
		}

		//$baseUrl = $this->router->generate('site_root',[],true);

		$thumbnail = !$entity->getMetaThumbnail() ? $this->getImageBaseUrl('images/main.jpg') : $this->getImageBaseUrl($entity->getMetaThumbnail($entity->getMetaThumbnail()));

		$meta = '';
		$meta .=sprintf('<meta name="description" content="%s" />', $entity->getMetaDescription());
		$meta .=sprintf('<meta name="author" content="%s" />', $entity->getMetaAuthor());
		$meta .=sprintf('<meta property="og:title" content="%s"/>', $entity->getTitle());
		$meta .=sprintf('<meta property="og:description" content="%s"/>', $entity->getMetaDescription());
		$meta .=sprintf('<meta property="og:image" content="%s"/>', $thumbnail);
		$meta .=sprintf('<meta property="og:url" content="%s"/>', $this->request->getUri());
		//die($entity->getMetaTitle());

		$this->template->bind('seoMetaInfo', $meta);
	}

	private function getImageBaseUrl($imgPath)
	{
		//$imgPath = ltrim($imgPath,'/');
		$baseUrl =  $this->request->getHttpHost() . $this->request->getBasePath();
		$sep = (substr($baseUrl,-1) =='/') ? '':'/';
		$baseUrl2 = $baseUrl.$sep;

		return $this->request->getScheme() . '://'.$baseUrl2.$imgPath;

	}	

}
