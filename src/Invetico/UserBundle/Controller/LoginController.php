<?php

namespace Invetico\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Invetico\BoabCmsBundle\Controller\BaseController;
use Invetico\BoabCmsBundle\Controller\InitializableControllerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Invetico\BoabCmsBundle\Controller\PublicControllerInterface;

Class LoginController extends BaseController  implements PublicControllerInterface, InitializableControllerInterface 
{
    private $authenticationUtils;

    function __Construct(AuthenticationUtils $authenticationUtils) 
    {
        $this->authenticationUtils = $authenticationUtils;
    }


    public function initialize()
    {
        $this->template->setTheme('kantua');
    }

    public function loginAction(Request $request)
    {
        $login = $this->template->load('UserBundle:Main:login.html.twig');
        //$login->action = $this->router->generate('_login_check');
        //$login->resetPasswordLink = $this->router->generate('password_recover');
        $login->authError = $this->authenticationUtils->getLastAuthenticationError();

        $this->template->setTitle('Login')
             ->bind('content',$login)
             ->setBlock('contentArea','plain_tpl.html.twig');

        return $this->template;
    } 

    public function checkloginAction(Request $request)   
    {
        
    }

}
