<?php

namespace Invetico\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Invetico\BoabCmsBundle\Controller\BaseController;
use Invetico\BoabCmsBundle\Controller\InitializableControllerInterface;
use Invetico\UserBundle\Service\UserService;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Invetico\BoabCmsBundle\Controller\PublicControllerInterface;
use Invetico\UserBundle\Repository\UserRepositoryInterface;
use Invetico\UserBundle\Repository\TokenRepositoryInterface;

Class ActivationController extends BaseController  implements PublicControllerInterface, InitializableControllerInterface 
{
    private $userService;
    private $userRepository;
    private $tokenRepository;

    CONST ACTIVATION_TIMEOUT = '20';

    function __Construct(UserService $userService, UserRepositoryInterface $userRepository, TokenRepositoryInterface $tokenRepository) 
    {
        $this->userService = $userService;
        $this->userRepository = $userRepository;
        $this->tokenRepository = $tokenRepository;
    }


    public function initialize()
    {
        $this->template->setTheme('kantua');
    }


    public function verifyAction(Request $request)
    {
        $notice = $this->template->load('UserBundle:Register:register_confirmation');
        $notice->flash = $this->flash;
        $this->template->setTitle('Registration: Email confirmation')
                     ->bind('content',$notice)
                     ->setBlock('contentArea',$this->template->loadBlock('UserBundle:Main:no_block_tpl'));

        return $this->template;
    }


    public function activateAction(Request $request)
    {
        $token = $request->query->get('token');
        $userToken = $this->tokenRepository->findByToken($token);
        if(!$userToken){
            return $this->pageNotfound('Invalid token');
        }

        if(!$this->isValidToken($userToken)){
            die('Your activation has exired');
        }
        $this->userService->activate($userToken->getUser());

        return $this->redirect($this->urlGenerator->generate('activate_success'));
    }


    public function isValidToken($userToken)
    {
        $tokenDate = $userToken->getDateCreated();
        $tokenDate->add(new \DateInterval('PT' . self::ACTIVATION_TIMEOUT . 'M'));
        $nowDate = new \DateTime('now');
        if($nowDate > $tokenDate ){
            return false;
        }        
        return true;
    }


    public function thankYouAction(Request $request)
    {
        $notice = $this->template->load('UserBundle:Register:thank_you');
        $notice->flash = $this->flash;
        $this->template->setTitle('Thank You')
                     ->bind('content',$notice)
                     ->setBlock('contentArea',$this->template->loadBlock('UserBundle:Main:no_block_tpl'));

        return $this->template;        
    }

}
