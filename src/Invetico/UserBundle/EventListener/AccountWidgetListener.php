<?php

namespace Invetico\UserBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\Routing\RouterInterface;
use Invetico\BoabCmsBundle\Controller\AdminController;
use Invetico\BoabCmsBundle\Controller\AccountPanelInterface;
use Invetico\UserBundle\Security\SecurityContext;
use Invetico\UserBundle\Controller\AccountController;
use Invetico\BoabCmsBundle\View\Template;
use Invetico\BoabCmsBundle\View\ViewFactory;


class AccountWidgetListener
{
    private $router;
    private $securityContext;
    private $template;

    public function __construct(RouterInterface $router, SecurityContext $securityContext, Template $template)
    {
        $this->router = $router;
        $this->securityContext = $securityContext;
        $this->template = $template;
    }


    public function onControllerEvent(FilterControllerEvent $event)
    {
        if ($event->getRequestType() === HttpKernelInterface::SUB_REQUEST) {
            return;
        }

        $controller = $event->getController();
        $userToken = $this->securityContext->getIdentity();

        if ($controller[0] instanceof AdminController) {
            $view = $this->template->load('UserBundle:Account:user_thumbnail.html.twig');
            $view->userToken = $userToken;
            $this->template->bind('profile_thumbnail', $view->render());
        }

        if ($controller[0] instanceof AdminController) {
            $this->template->bind('metaNavigation', $this->topToolbar());
        }

        if ($controller[0] instanceof AccountPanelInterface) {
            $this->template->bind('sidebarProfile', $this->sidebarProfileWidget($userToken));
            $this->template->bind('metaNavigation', $this->topToolbar());
        }
    }


    private function sidebarProfileWidget($user)
    {
        $view = $this->template->load('UserBundle:Account:sidebar_profile');
        $view->user = $user;
        return $view;
    }


    public function topToolbar()
    {
        $userToken = $this->securityContext->getIdentity();
        if (!$userToken) {
            return;
        }
        $viewFile = 'authenticated_user_toolbar';
        if ($this->securityContext->hasRole('ROLE_SUPER_ADMIN')) {
            $viewFile = 'authenticated_admin_toolbar';
        }
        $view = $this->template->load(sprintf('UserBundle:Account:%s.html.twig', $viewFile));
        $view->user = $userToken;
        $view->generate = function ($routeName) {
            return $this->router->generate($routeName);
        };

        return $view;
    }
}
