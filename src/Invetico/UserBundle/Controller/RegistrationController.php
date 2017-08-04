<?php

namespace Invetico\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Invetico\UserBundle\Service\UserService;
use Invetico\UserBundle\Event\AccountRegisteredEvent;
use Invetico\UserBundle\Event\PasswordForgottenEvent;
use Invetico\UserBundle\Validation\ForgetPasswordFormValidation;
use Invetico\UserBundle\Validation\ResetPassword;
use Invetico\BoabCmsBundle\Helper\RandomStringGenerator;
use Invetico\BoabCmsBundle\Controller\AdminController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Invetico\UserBundle\Validation\Register as RegisterValidation;

/**
 * @Security("has_role('ROLE_ADMIN')")
 */ 
Class RegistrationController extends AdminController
{
    private $userService;
    private $randomGenerator;
    private $encoder;

    use RandomStringGenerator;

    function __Construct(UserService $userService, $randomGenerator, $encoder) 
    {
        $this->userService = $userService;
        $this->randomGenerator = $randomGenerator;
        $this->encoder = $encoder;
    }

    public function initialize()
    {
        $this->template->setTheme('kantua');
    }

    public function registerAction(Request $request)
    {
        $url = $this->urlGenerator->generate('member_register');

        if('POST' === $request->getMethod()){

            $this->validation->validateRequest($request, new RegisterValidation());
            $this->validation->delegate('username',array($this->userService,'validateUsername'));
            $this->validation->delegate('email',array($this->userService,'validateEmail'));

            if(!$this->validation->isValid()){
                $this->flash->setErrors($this->validation->getErrors());
                $this->flash->setValues($request->request->all());
                return $this->redirect($url);
            }
            try{
                $user = $this->userService->registerMember($request);

                $password = $this->encoder->encodePassword($user, $request->get('password'));
                $user->setPassword($password);
                //$string = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                //$token = $this->randomGenerator->generate(32,$string);
                //echo $token;
                //die();
/*
                $activateToken = new \Invetico\UserBundle\Entity\MailToken;
                $activateToken->setToken($this->getActivationToken());
                $activateToken->setDateCreated(new \DateTime('now'));
                $activateToken->setUser($user);
                $user->addToken($activateToken);
                */

                //$event = new AccountRegisteredEvent($user);
                //$this->eventDispatcher->dispatch('user.account_registered',$event);
            
                $this->userService->save($user);
            }catch(\Exception $e){
                $this->flash->setErrors(['error'=>$e->getMessage()]);
                return $this->redirect($url);
            }

            return $this->redirect($this->urlGenerator->generate('register_verify'));
        }
        
        $view = $this->template->load('UserBundle:Register:register');
        $view->action = $this->urlGenerator->generate('member_register');
        $view->login = $this->urlGenerator->generate('_login');
        $view->country = $request->get('_country');
        $view->flash = $this->flash;
        $this->template->setTitle('User Registration')
                     ->bind('page_header',$this->template->getTitle())
                     ->bind('content',$view)
                     ->setBlock('contentArea',$this->template->loadBlock('UserBundle:Main:no_block_tpl'));

        return $this->template;
    }

}
