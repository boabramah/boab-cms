<?php

namespace Invetico\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Invetico\UserBundle\Service\UserService;
use Invetico\BoabCmsBundle\Controller\AdminController;
use Invetico\BoabCmsBundle\Controller\InitializableControllerInterface;
use Invetico\UserBundle\Event\AccountTerminatedEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Invetico\UserBundle\Repository\userRepositoryInterface;
use Invetico\UserBundle\Validation\AddUserValidation;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Security("has_role('ROLE_ADMIN')")
 */	
Class UserController extends AdminController implements InitializableControllerInterface
{	
	private $userService;
	private $encoder;

	function __Construct(UserService $userService, UserPasswordEncoderInterface $encoder)
	{
		$this->userService = $userService;
		$this->encoder = $encoder;
	}


	public function initialize()
	{
		$this->template->setTheme('novi');
	}


	function indexAction(Request $request)
	{
		$page = $request->get('page',1);

		$collection = $this->userService->findAll($page);

		$option = [
			'page_total_rows' => $collection->count(),
			'page_number'=>$page,
			'page_url'=>$this->router->generate('admin_user_index')
		];

		$view = $this->template->load('UserBundle:Admin:users');
		$view->collection = $collection;
		$view->pagination = $this->pagination->generate($option);
		$view->generateDeleteUrl = function($user){
			return $this->router->generate('admin_user_delete',['username'=>$user->getUsername(),'token'=>md5($user->getUsername().$user->getSalt())]);
		};

		$view->generateViewRolesUrl = function($user){
			return $this->router->generate('admin_role_user',['username'=>$user->getUsername()]);
		};
		
		$this->template->bind('page_header','User Login & Authentication')
					   ->bind('content',$view);
		return $this->template;
	}


    public function addAction(Request $request)
    {
        $url = $this->router->generate('user_add');

        if('POST' === $request->getMethod()){

            $this->validation->validateRequest($request, new AddUserValidation());
            $this->validation->delegate('username',[$this->userService,'validateUsername']);
            $this->validation->delegate('email',[$this->userService,'validateEmail']);

            if(!$this->validation->isValid()){
				var_dump($this->validation->getErrors());
				die;
				$this->flash->setErrors($this->validation->getErrors());
                $this->flash->setValues($request->request->all());
                return $this->redirect($url);
            }
			
            try{
				$user = new \Invetico\UserBundle\Entity\Employee;
				$user->setUsername($request->get('username'));
				$user->setFirstname( $request->get('user_first_name') );
				$user->setLastname( $request->get('user_last_name') );
				$user->setContactNumber( $request->get('contact_number'));
				$user->setEmail($request->get('email'));
				$user->setSalt();
				$user->setRoles(['ROLE_USER']);
				$user->setDateRegistered(new \DateTime);
				$user->setAccountStatus('registered');
				$user->setIsLoggedIn(0);
                $password = $this->encoder->encodePassword($user, $request->get('password'));
                $user->setPassword($password);
                
				$this->userService->save($user);
                
				$this->flash->setSuccess(sprintf('User <strong>%s</strong> created successfully', $user->getLastname()));
				die('ffghfhf');
            
			}catch(\Exception $e){
				die($e->getMessage());
                $this->flash->setErrors(['error'=>$e->getMessage()]);
                return $this->redirect($url);
            }

            return $this->redirect($url);
        }
        
        $view = $this->template->load('UserBundle:User:add');
        $view->action = $url;
        $view->flash = $this->flash;
        $this->template->setTitle('Add User')
                     ->bind('page_header',$this->template->getTitle())
                     ->bind('content',$view);

        return $this->template;
    }


	public function deleteAction(Request $request)
	{
		$username = $request->get('username');
		$token = $request->get('token');

		//$this->userService->terminate($user);
		$user = $this->userService->findByUsername($username);

		if(!$user){
			return $this->pageNotFound('The user does not exist');
		}

		if($token != md5($user->getUsername().$user->getSalt())){
			return $this->pageNotFound('This request is invalid');
		}
		$msg = sprintf('The user <strong>%s</strong> deleted successfully',$user->getFullName());
		
        $accountTerminatedEvent = new AccountTerminatedEvent($user);
        $this->eventDispatcher->dispatch('user.account_terminated',$accountTerminatedEvent);
        
        $this->userService->delete($user);

        $this->flash->setSuccess($msg);

        return $this->redirect($this->router->generate('admin_user_index'));
	}


}
