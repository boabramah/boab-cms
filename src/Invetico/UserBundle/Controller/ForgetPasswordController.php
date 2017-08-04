<?php

namespace Invetico\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Invetico\BoabCmsBundle\Controller\BaseController;
use Invetico\BoabCmsBundle\Controller\InitializableControllerInterface;
use Invetico\UserBundle\Service\UserService;
use Invetico\UserBundle\Event\PasswordForgottenEvent;
use Invetico\UserBundle\Validation\ForgetPasswordFormValidation;
use Invetico\UserBundle\Validation\ResetPassword;
use Invetico\BoabCmsBundle\Controller\PublicControllerInterface;
use Invetico\BoabCmsBundle\Helper\RandomStringGenerator;
use Invetico\UserBundle\Repository\TokenRepositoryInterface;
use Invetico\UserBundle\Exception\InvalidTokenException;
use Invetico\UserBundle\Repository\UserRepositoryInterface;

Class ForgetPasswordController extends BaseController  implements PublicControllerInterface, InitializableControllerInterface 
{
    private $userService;
    private $userRepository;
    private $tokenRepository;   
    CONST RESET_TIMEOUT = 2;

    use RandomStringGenerator;

    function __Construct
    (
        UserService $userService, 
        UserRepositoryInterface $userRepository,
        TokenRepositoryInterface $tokenRepository
    ) 
    {
        $this->userService = $userService;
        $this->userRepository = $userRepository;
        $this->tokenRepository = $tokenRepository;
    }


    public function initialize()
    {
        $this->template->setTheme('kantua');
    }


    public function recoverAction(Request $request)
    {
        if('POST' === $request->getMethod()){
            $validation = new ForgetPasswordFormValidation($request->request->all());
            $validation->delegate('email',[$this->userService,'emailExist']);
            if(!$validation->isValid()){
                $this->flash->setErrors($validation->getErrors());
                $this->flash->setValues($request->request->all());

                return $this->redirect($this->urlGenerator->generate('password_recover'));
            }
            
            $user = $this->userService->findByEmail($request->get('email'));
            $activateToken = new \Invetico\UserBundle\Entity\MailToken;
            $activateToken->setToken($this->getActivationToken());
            $activateToken->setDateCreated(new \DateTime('now'));
            $activateToken->setUser($user);
            $user->addToken($activateToken);

            try {
                $passwordEvent = new PasswordForgottenEvent($user);
                $this->eventDispatcher->dispatch('user.password_forgotten',$passwordEvent);                          
                $this->userService->save($passwordEvent->getUser());
             } catch (\Exception $e) {
                $this->flash->setInfo($e->getMessage());      
                return $this->redirect($this->urlGenerator->generate('password_recover'));
            }            
            $this->flash->setInfo('A password reset link has been email to you');
            return $this->redirect($this->urlGenerator->generate('password_recover'));
        }

        $login = $this->template->load('UserBundle:Register:forget_password');
        $login->action = $this->urlGenerator->generate('password_recover');
        $login->flash = $this->flash;
        $this->template->setTitle('Forget Password')
                     ->bind('content',$login)
                     ->setBlock('contentArea',$this->template->loadBlock('UserBundle:Main:no_block_tpl'));
        return $this->template;
    }

    public function validateToken($token, $timeOut)
    {
        if(!$token){
            throw new InvalidTokenException("Your request to the server is invalid");
        }
        $tokenDate = $token->getDateCreated();
        $tokenDate->add(new \DateInterval('PT' . $timeOut . 'M'));
        $nowDate = new \DateTime('now');
        if($nowDate > $tokenDate ){
            throw new InvalidTokenException("The reset password link has expire");
        }        
        return true;
    }    


    public function resetAction(Request $request)
    {
        $token = $request->query->get('token');
        $userToken = $this->tokenRepository->findByToken($token);

        $this->validateToken($userToken, self::RESET_TIMEOUT);

        if('POST' === $request->getMethod()){
            $validation = new ResetPassword($request->request->all());
            if(!$validation->isValid()){
                $this->flash->setErrors($validation->getErrors());
                $this->flash->setValues($request->request->all());
                return $this->redirect($this->urlGenerator->generate('password_reset',['token'=>$token]));
            }

            $user = $userToken->getUser();
            $user->setPassword($request->get('password'));
            $this->userService->save($user);

            return $this->redirect($this->urlGenerator->generate('_login'));
        }        

        $view = $this->template->load('UserBundle:Register:password_reset');
        $view->action = $this->urlGenerator->generate('password_reset',['token'=>$token]);
        $view->flash = $this->flash;
        $this->template->setTitle('Reset Password')
                     ->bind('content',$view)
                     ->setBlock('contentArea',$this->template->loadBlock('UserBundle:Main:no_block_tpl'));

        return $this->template;
    }

}
