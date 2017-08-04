<?php

namespace Invetico\UserBundle\Security\Authentication;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
 
class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    protected 
        $router,
        $authorizationChecker;
    
    public function __construct(RouterInterface $router, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->router = $router;
        $this->authorizationChecker = $authorizationChecker;
    }
    
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        // URL for redirect the user to where they were before the login process begun if you want.
        // $referer_url = $request->headers->get('referer');
        
        // Default target for unknown roles. Everyone else go there.
        $url = 'dashboard_area';

        if($this->authorizationChecker->isGranted('ROLE_ADMIN')) {
            $url = 'dashboard_area';

        }
        elseif($this->authorizationChecker->isGranted('ROLE_EDITOR')) {
           // $url = 'store_item_list';            
        }

        return new RedirectResponse($this->router->generate($url));
    }
}



