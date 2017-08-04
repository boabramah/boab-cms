<?php

namespace Invetico\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Invetico\BoabCmsBundle\Controller\BaseController;
use Invetico\BoabCmsBundle\Controller\AccountPanelInterface;
use Invetico\BoabCmsBundle\Controller\InitializableControllerInterface;
use Invetico\UserBundle\Service\UserService;
use Invetico\UserBundle\Entity\Privacy;
use Invetico\UserBundle\Event\ProfileUpdatedEvent;
use Invetico\UserBundle\Event\ProfileThumbnailUploadEvent;
use Invetico\LocationBundle\Service\LocationService;
use Invetico\UserBundle\Validation\Login;
use Invetico\UserBundle\Validation\PasswordChange;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

Class AccountController extends BaseController implements AccountPanelInterface, InitializableControllerInterface
{
    private $userService;
    private $userIdentity;
    private $locationService;
    private $encoder;
    
    public function __Construct(UserService $userService, UserPasswordEncoderInterface $encoder) 
    {
        $this->userService = $userService;
        $this->encoder = $encoder;
    }


    public function initialize()
    {
        //die('account');

        $this->template->setTheme('jayle');
        //$this->template->bind('script_files',$this->asset->script(['profile_script']));
        $this->userIdentity = $this->securityContext->getIdentity();
    }


    public function indexAction(Request $request) 
    {
        $user = $this->userService->findById($this->userIdentity->getId());

        $view = $this->template->load('UserBundle:Account:account_dashboard');
        $view->user = $user;
        $this->template->setTitle('Dashboard')
             ->bind('page_header','Dashboard')
             ->bind('content',$view);
             //->setBlock('contentArea', $this->template->loadBlock('UserBundle:Account:account_dashboard_tpl'),true);
        return $this->template;
    }


    public function profileAction(Request $request)
    {
        $url = $this->urlGenerator->generate('account_settings_profile');
        $user = $this->userService->findById($this->userIdentity->getId());

        if('POST' === $request->getMethod()){
            $validation = new \Invetico\UserBundle\Validation\ProfileUpdate($request->request->all());
            if(!$validation->isValid()){
                $this->flash->setErrors($validation->getErrors());
                return $this->redirect($url);
            }
            $this->userService->update($user);
            $this->flash->setSuccess('Profile updated successfully');
            $this->eventDispatcher->dispatch('user.profile_updated',new ProfileUpdatedEvent($user));
            return $this->redirect($url);
        }

        $view = $this->template->load('UserBundle:Account:account_profile');
        $view->user = $user;
        $view->flash = $this->flash;
        $view->action = $url;
        //$view->countriesOption = $this->locationService->getAllCountriesOptionList($user->getCountry()->getId());
        $this->template->setTitle('Account Info');
        $this->template->bind('content',$view)
                     ->bind('page_header','Edit Your Profile');
        return $this->template;
    }


    public function privacyAction(Request $request)
    {
        if('POST' === $request->getMethod()){

            $user = $this->userService->findById($this->userIdentity->getId());
            if(!$user){
                throw new \Exception("Error Processing Request", 1);
            }

            $privacy = (!$user->getPrivacy()) ? new Privacy() : $user->getPrivacy();
            $privacy->setRecieveNewsletter($request->request->has('recieve_newsletter'));
            $privacy->setAdviceBuyingAndSelling($request->request->has('advice_buy_sell'));
            $privacy->setShowAds($request->request->has('show_ads'));
            $privacy->setShowComments($request->request->has('show_comment'));
            $privacy->setSigneInFacebook($request->request->has('facebook_sign_on'));
            $privacy->setPostOnFacebook($request->request->has('ads_on_facebook'));

            $user->setPrivacy($privacy);
            $this->userService->save($user);
            $this->flash->setSuccess('Privacy settings updated successfully');
            return $this->redirect($this->urlGenerator->generate('user_settings_privacy'));
        }
        $user = $this->userService->findById($this->userIdentity->getId());

        $view = $this->template->load('UserBundle:Account:privacy_settings');
        $view->action = $this->urlGenerator->generate('user_settings_privacy');
        $view->privacy = (!$user->getPrivacy()) ? new Privacy() : $user->getPrivacy();
        $this->template->setTitle('Privacy settings')
                     ->bind('page_header','Privacy Settings')
                     ->bind('content',$view);
        return $this->template;
    }


    public function changePasswordAction(Request $request)
    {
        $redirect = $this->urlGenerator->generate('account_settings_password');
        
        if('POST' === $request->getMethod()){
            $user = $this->userService->findById($this->userIdentity->getId());
            if(!$user){
                throw new \Exception("Error Processing Request", 1);
            }

            $this->validation->validateRequest($request, new PasswordChange());
            $this->validation->delegate('current_password',function($password)use($user){
                $this->userService->validatePassword($user, $password);
            });

            if(!$this->validation->isValid()){
                $this->flash->setErrors($this->validation->getErrors());
                $this->flash->setValues($request->request->all());
                return $this->redirect($redirect);
            }

            $user->setPassword($request->get('password1'));
            $this->userService->save($user);
            $this->flash->setSuccess('Password updated successfully');
            return $this->redirect($redirect);
        }

        $view = $this->template->load('UserBundle:Account:account_change_password');
        $view->action = $redirect;
        $view->flash = $this->flash;
        $this->template->setTitle('Change Password')
                     ->bind('page_header', 'Change Password')
                     ->bind('content',$view);
        return $this->template;
    }


    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function terminateAction(Request $request)
    {
        $email = $this->userIdentity->getEmail();
        $password = $request->get('password');

        $redirect = $this->urlGenerator->generate('account_terminate');

        if('POST' === $request->getMethod()){
            if(!$this->validateParams(compact('email','password'))){
                $this->flash->setError('password','Please enter your password to continue');
                return $this->redirect($redirect);
            }

            $validator = new Login(compact('email','password'));
            if(!$validator->isValid()){
                $this->flash->setError('password','Your password is invalid');
                return $this->redirect($redirect);
            }

            $user = $this->userService->findByEmail($email);
            if(!password_verify($password ,$user->getPassword())){
                $this->flash->setError('password','Your password is invalid');
                return $this->redirect($redirect);
            }
            //$accountTerminatedEvent = new AccountTerminatedEvent($user);
            //$this->eventDispatcher->dispatch('user.account_terminated',$accountTerminatedEvent);
            
            /*
            if($this->securityContext->hasIdentity()){
                $this->securityContext->clearIdentity();
            }
            */

            $this->userService->terminate($user);
            //$this->userService->delete($user);


            $this->flash->setInfo('Your account has been terminated successfully');
            return $this->redirect($this->urlGenerator->generate('account_terminate_success'));
        }
        

        $view = $this->template->load('UserBundle:Account:account_delete');
        $view->flash = $this->flash;
        $view->action = $this->urlGenerator->generate('account_terminate');

        $this->template->setTitle('Delete Account')
                       ->bind('page_header','Delete Account')
                       ->bind('content',$view);
        return $this->template;
    }    


    public function sidebarMenu()
    {
        $menuItems = [

            [
                'title'         =>'Dashboard',
                'route_name'    => 'account_home'
            ],

            [
                'title'         =>'Your Profile',
                'route_name'    => 'account_settings_profile'
            ],            

            [
                'title'         =>'Password',
                'route_name'    => 'account_settings_password'
            ],            
            
            /*
            [
                'title'         =>'Privacy Settings',
                'route_name'    => 'user_settings_privacy'
            ],
            */
            
            [
                'title'         =>'Delete Account',
                'route_name'    => 'account_terminate'
            ], 

        ];

        return $menuItems;
    }

}
