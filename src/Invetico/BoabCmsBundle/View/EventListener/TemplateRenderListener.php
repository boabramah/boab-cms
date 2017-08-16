<?php

namespace Invetico\BoabCmsBundle\View\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Invetico\BoabCmsBundle\View\Template;
use Invetico\BoabCmsBundle\View\TemplateInterface;
use Invetico\BoabCmsBundle\View\ThemeManagerInterface;
use Maiorano\Shortcodes\Manager\ShortcodeManager;


class TemplateRenderListener implements EventSubscriberInterface
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
        $template = $event->getControllerResult();
        if (!$template instanceof TemplateInterface) {
            throw new \Exception("You must return the template object in your controllersxxx", 1);
        }
        $event->setResponse(new Response($template->render()));
    }

    public static function getSubscribedEvents()
    {
        return [ 
            KernelEvents::VIEW => [['onKernelController', 30]],
            KernelEvents::VIEW => [['onKernelView', 30]],
            KernelEvents::VIEW => [['onKernelResponse', 30]],
            KernelEvents::VIEW => [['onKernelException', 200]]            
        ];
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {        
        $request = $event->getRequest();
        $result = $event->getResponse();

        if ($this->controller[0] instanceof AdminControllerInterface) {
            return;
        }
        $content = $event->getResponse()->getContent();
        if (!$this->shortcodeManager->hasShortcode($content)) {
            return;
        }

        $content = $this->shortcodeManager->doShortcode($content, null, true);
        $event->getResponse()->setContent($content);
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