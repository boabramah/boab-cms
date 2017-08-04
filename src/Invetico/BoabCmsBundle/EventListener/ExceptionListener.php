<?php

namespace Invetico\BoabCmsBundle\EventListener;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Routing\RouterInterface;
use Invetico\BoabCmsBundle\View\TemplateInterface;
use Invetico\UserBundle\Exception\InvalidTokenException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;

class ExceptionListener 
{	
	private $template;
	private $router;
	private $tokenStorage;

	public function __construct(TemplateInterface $template, RouterInterface $router, TokenStorageInterface $tokenStorage) 
	{
		$this->template = $template;
		$this->router = $router;
		$this->tokenStorage = $tokenStorage;
    }

	public function onKernelException(GetResponseForExceptionEvent $event) 
	{
		$exception = $event->getException();
		$request = $event->getRequest();
		$response = $this->handleHtmlExceptionResponse($exception, $request);
		$event->setResponse($response);
	}

	
	private function handleHtmlExceptionResponse($exception, $request)
	{
		if ($exception instanceof NotFoundHttpException) {
			return $this->getHtmlResponse($exception, 'Page Not Found', 'kantua', 'plain_tpl.html.twig');
		}

		if ($exception instanceof InvalidTokenException) {
			return $this->getHtmlResponse($exception, 'Internal Server Error', 'kantua','plain_tpl.html.twig');
		}		

		if ($exception instanceof AccessDeniedException) {
			$token = $this->tokenStorage->getToken();
			if($token instanceof AnonymousToken){
				return new RedirectResponse($this->router->generate('_logout'));
			}
			return $this->getHtmlResponse($exception, 'Access Denied', 'novi','home_page_tpl.php');
		}
		throw $exception;
	}

	private function getHtmlResponse($exception, $title, $theme, $layout)
	{
		$statusCode = ($exception instanceof HttpExceptionInterface) ? $exception->getStatusCode() : $exception->getCode();

		$view = $this->template->load(sprintf('BoabCmsBundle:Exception:exception_%s.html.twig', $statusCode));
		$view->exception = $exception;
		$this->template->setTitle($title)
			->bind('content', $view)
			->bind('page_header',$title)
			->setTheme($theme)					       
			->setBlock('contentArea',$this->template->loadThemeBlock($layout), true);
		$response = new Response($this->template->render());
		$response->setStatusCode($statusCode);
		return $response;	
	}
}