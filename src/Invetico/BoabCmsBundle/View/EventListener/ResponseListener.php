<?php

namespace Invetico\BoabCmsBundle\View\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Invetico\BoabCmsBundle\Controller\AdminControllerInterface;
use Maiorano\Shortcodes\Manager\ShortcodeManager;
use Invetico\BoabCmsBundle\View\TemplateInterface;
use Invetico\BoabCmsBundle\View\ThemeManagerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;


class ResponseListener implements EventSubscriberInterface
{
    private $template;
    private $themeManager;
    private $shortCodeManager;

    public function __construct(TemplateInterface $template, ThemeManagerInterface $themeManager, ShortcodeManager $shortCodeManager)
    {
        $this->template = $template;
        $this->themeManager = $themeManager;
        $this->shortCodeManager = $shortCodeManager;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $this->controller = $event->getController();
    }
    
    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        $request = $event->getRequest();
        $controllerResult = $event->getControllerResult();

        if ($controllerResult instanceof TemplateInterface) {
            $html = $controllerResult->render();
            $response = new Response($html);
            $response->setStatusCode(200);            
            $event->setResponse($response);
            return;
        }
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {        
        $request = $event->getRequest();
        $result = $event->getResponse();

        if ($this->controller[0] instanceof AdminControllerInterface) {
            return;
        }
        $content = $event->getResponse()->getContent();
        if (!$this->shortCodeManager->hasShortcode($content)) {
            return;
        }

        $content = $this->shortCodeManager->doShortcode($content, null, true);
        $event->getResponse()->setContent($content);
    }

    private function handleHtmlResponse(TemplateInterface $template, Request $request)
    {
        $response = new Response($template->render());
        $response->setStatusCode(200);
        return $response;
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
            return $this->getHtmlResponse(404, $exception, 'Page Not Found', 'plain_tpl.html.twig');
        }

        if ($exception instanceof InvalidTokenException) {
            return $this->getHtmlResponse(500, $exception, 'Internal Server Error', 'plain_tpl.html.twig');
        }

        if ($exception instanceof AccessDeniedException) {
            /*
            $token = $this->tokenStorage->getToken();
            if($token instanceof AnonymousToken){
                return new RedirectResponse($this->router->generate('_logout'));
            }
            */
            return $this->getHtmlResponse(500, $exception, 'Access Denied', 'home_page_tpl.php');
        }
        throw $exception;
    }

    private function getHtmlResponse($code, $exception, $title, $layout)
    {
        $statusCode = ($exception instanceof HttpExceptionInterface) ? $exception->getStatusCode() : $exception->getCode();

        $view = $this->template->load(sprintf('BoabCmsBundle:Exception:exception_%s.html.twig', $code));
        $view->exception = $exception;
        $this->template->setTitle($title)
            ->bind('content', $view)
            ->bind('page_header', $title)
            ->setTheme($theme)
            ->setBlock('contentArea', $this->template->loadThemeBlock($layout), true);
        $response = new Response($this->template->render());
        $response->setStatusCode($statusCode);
        return $response;
    }          

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => [['onKernelController', 30]],
            KernelEvents::VIEW => [['onKernelView', 30]],
            KernelEvents::RESPONSE => [['onKernelResponse', 30]],
            KernelEvents::EXCEPTION => [['onKernelException', 200]] 
        ];
    }

} 
