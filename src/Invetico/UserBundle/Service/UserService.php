<?php

namespace Invetico\UserBundle\Service;


use Invetico\UserBundle\repository\UserRepositoryInterface;
use Invetico\UserBundle\Entity\User;
use Invetico\BoabCmsBundle\Service\BaseService;
use Invetico\BoabCmsBundle\Validation\Exception\InvalidDataException;
use Invetico\BoabCmsBundle\Helper\EventDispatcherHelper;

Class UserService extends BaseService
{ 
	private $repository;

	use EventDispatcherHelper;
	
	function __Construct(UserRepositoryInterface $repository)
	{
		$this->repository = $repository;
	}

	public function create($request, $callback=null)
	{
		return parent::create($request, function($entity, $request){
			$entity->setStatus('offline');
			$entity->resetPasswordAndSalt($request->get('user_password1'));
		});
	}

	public function update($user, $callback=null)
	{
		return parent::update($user, function($entity, $request){
			
		});
	}

	public function register($request)
	{
		$user = $this->createEntity();
		$user->setUsername($request->get('username'));
		$user->setFirstname( $request->get('user_first_name') );
		$user->setLastname( $request->get('user_last_name') );
		$user->setEmail($request->get('email'));
		$user->setPassword($request->get('password'));
		$user->setRoles(['ROLE_USER']);
		$user->setAccountType($request->get('account_type'));
		$user->setDateRegistered(new \DateTime);
		$user->setAccountStatus('inactive');
		$user->setIsActivated(0);
		$user->setIsLoggedIn(0);

		/*
		$state = $this->locationRepository->findOneBy(array('id'=>$request->get('user_state')));
		$entity->setCountry($state);

		$city = $this->locationRepository->findOneBy(array('id'=>$request->get('user_city')));
		$entity->setCountry($city);
		*/
		$this->save($user);
		$this->entityManager->refresh($user);
		return $user;
	}

	public function registerMember($request)
	{
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
		return $user;
	}	


	public function populateEntity( $entity, $request )
	{
		$entity->setFirstname( $request->get('user_first_name') );
		$entity->setLastname( $request->get('user_last_name') );
		$entity->setContactnumber( $request->get('user_contact_number') );
		$entity->setEmail( $request->get('user_email') );
		$entity->setAddress( $request->get('user_address') );
		//$entity->setCity( $request->get('user_city') );
		
		//$country = $this->locationRepository->findOneBy(array('id'=>$request->get('user_country')));
		//$entity->setCountry($country);

		$entity->setPostalcode($request->get('user_postalcode'));

		return $entity;
	}

	public function createEntity()
	{
		return new User();
	}


	public function findById($id)
	{
		return $this->repository->findUserById($id);
	}


	public function findByEmail($email)
	{
		return $this->fetchUserInfo(array('email' => $email));
	}


	public function findByUsername($username)
	{
		return $this->fetchUserInfo(array('username' => $username));
	}


	private function fetchUserInfo( array $criteria = array())
	{
		return $this->repository->findOneBy($criteria);
	}


	public function changePassword($user)
	{
		$user->resetPasswordAndSalt($this->request->get('password1'));
		$this->save($user);
		return;
	}


	public function validatePassword($user, $password)
	{
		if(!password_verify($password, $user->getPassword())){
			throw new InvalidDataException('The current password did not match the one on file');
		}
		return true;
	}


	public function emailExist($email)
	{
		if(!$this->fetchUserInfo(array('email' => $email))){
			throw new InvalidDataException(sprintf('The email (%s) does not exist in our database',$email));
		}
		return true;
	}

	public function validateUsername($username)
	{
		if($this->repository->findUserByUserName($username)){
			throw new InvalidDataException(sprintf('The username (%s) has already been taken',$username));
		}
		return true;
	}

	public function validateEmail($email)
	{
		if($this->findByEmail($email)){
			throw new InvalidDataException(sprintf('Someone has already registered with this email'));
		}
		return true;
	}


	public function findAll($page)
	{
		return $this->repository->findAllUsers($page);
	}


	public function activate($user)
	{
		$user->setIsActivated(1);
		$user->setAccountStatus('active');
		$this->save($user);
		return true;
	}

	public function terminate($user)
	{
		$user->setAccountStatus('blocked');
		$this->save($user);
		return true;
	}
}
