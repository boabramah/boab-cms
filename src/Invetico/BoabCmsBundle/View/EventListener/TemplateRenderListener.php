<?php

namespace Invetico\BoabCmsBundle\View\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Invetico\BoabCmsBundle\View\Template;
use Invetico\BoabCmsBundle\View\TemplateInterface;
use Invetico\BoabCmsBundle\View\ThemeManager;


class TemplateRenderListener implements EventSubscriberInterface
{
	private $themeManager;

	public function __construct(ThemeManager $themeManager)
	{
		$this->themeManager = $themeManager;
	}
	

	public function onKernelView(GetResponseForControllerResultEvent $event)
	{
		$template = $event->getControllerResult();
		if(!$template instanceof TemplateInterface){
			throw new \Exception("You must return the template object in your controllersxxx", 1);
		}
		$template->finalizeSettings();
		$event->setResponse(new Response($template->render()));
	}


	public static function getSubscribedEvents()
    {
        return [ KernelEvents::VIEW => array(array('onKernelView', 30))];
    }

} 