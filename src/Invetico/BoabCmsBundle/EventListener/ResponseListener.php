<?php

namespace Invetico\BoabCmsBundle\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Invetico\BoabCmsBundle\Controller\AdminControllerInterface;
use Maiorano\Shortcodes\Manager\ShortcodeManager;
use Invetico\BoabCmsBundle\View\TemplateInterface;
use Invetico\BoabCmsBundle\View\ThemeManager;


class ResponseListener implements EventSubscriberInterface
{
	private $themeManager;
	private $shortcodeManager;
	private $controller;

	public function __construct(ThemeManager $themeManager,ShortcodeManager $shortcodeManager)
	{
		$this->themeManager = $themeManager;
		$this->shortcodeManager = $shortcodeManager;
	}

    public function onKernelController(FilterControllerEvent $event)
    {
        $this->controller = $event->getController();
    }	
	

	public function onKernelView(GetResponseForControllerResultEvent $event)
	{
		$request = $event->getRequest();
		$controllerResult = $event->getControllerResult();

		if($controllerResult instanceof TemplateInterface){
			$response = $this->handleHtmlResponse($controllerResult, $request);			
			$event->setResponse($response);
			return;
		}
	}


	public function onKernelResponse(FilterResponseEvent $event)
	{        
        $request = $event->getRequest();
		$result = $event->getResponse();

        if($this->controller[0] instanceof AdminControllerInterface){
        	return;
        }
        $content = $event->getResponse()->getContent();
		if(!$this->shortcodeManager->hasShortcode($content)){
			return;
		}

		$content = $this->shortcodeManager->doShortcode($content, null, true);
		$event->getResponse()->setContent($content);
	}	


	private function handleHtmlResponse(TemplateInterface $template, Request $request)
	{
		$response = new Response($template->render());
		$response->setStatusCode(200);
		return $response;		
	} 

	public static function getSubscribedEvents()
    {
        return array(
        	KernelEvents::CONTROLLER => array(array('onKernelController', 30)),
        	KernelEvents::VIEW => array(array('onKernelView', 30)),        	
        	KernelEvents::RESPONSE => array(array('onKernelResponse', 30))
        );
    }


} 