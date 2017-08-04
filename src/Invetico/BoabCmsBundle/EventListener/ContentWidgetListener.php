<?php

namespace Invetico\BoabCmsBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\RouterInterface;
use Invetico\BoabCmsBundle\View\Template;
use Invetico\BoabCmsBundle\Widget\WidgetBuilder;
use Invetico\BoabCmsBundle\Entity\Project;
use Invetico\BoabCmsBundle\Entity\House;
use Invetico\BoabCmsBundle\Helper\ContentHelper;
use Symfony\Component\Finder\Finder;
use Invetico\BoabCmsBundle\Entity\PageInterface;

class ContentWidgetListener
{
	private $widgetBuilder;
	private $template;
	private $router;
	private $finder;

	use ContentHelper;

	public function __construct(WidgetBuilder $widgetBuilder,Template $template, RouterInterface $router, Finder $finder)
	{
		$this->widgetBuilder = $widgetBuilder;
		$this->template = $template;
		$this->router = $router;
		$this->finder = $finder;
	}

	public function onKernelRequest(GetResponseEvent $event)
	{
		$request = $event->getRequest();
		if (!$event->getRequestType() === HttpKernelInterface::MASTER_REQUEST) {
			return;
		}
		if ('/' !== $request->getPathInfo()) {
			
		}

	}

	public function onContentNodeRender($event)
	{
		$currentEntity = $event->getNode();
		$nodeView = $event->getView();
	}
}
