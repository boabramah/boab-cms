<?php

namespace Invetico\UserBundle\Security\Authentication;

use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;

class LogoutSuccessHandler implements LogoutSuccessHandlerInterface
{
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function onLogoutSuccess(Request $request) 
    {
        
//die('loggedout');
        $referer = $request->headers->get('referer');
        //$request->getSession()->setFlash('success', 'Wylogowano');


        return new RedirectResponse($this->router->generate('_login'));
    }
}

