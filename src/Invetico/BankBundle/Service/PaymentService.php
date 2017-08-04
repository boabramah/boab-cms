<?php

namespace Invetico\BankBundle\Service;


use Invetico\BankBundle\repository\CustomerRepositoryInterface;
use Invetico\BoabCmsBundle\Service\BaseService;
use Arrow\Validation\Exception\InvalidDataException;

Class PaymentService extends BaseService
{ 
	private $repository;
	
	function __Construct(PaymentRepositoryInterface $repository)
	{
		$this->repository = $repository;
	}


	public function initialize()
	{
		
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
		$user->resetPasswordAndSalt($request->get('password'));
		$user->setRoles(['ROLE_USER']);
		$user->setAccountType($request->get('account_type'));
		$user->setDateRegistered(new \DateTime);
		$user->setAccountStatus('inactive');
		$user->setIsActivated(0);
		$user->setIsLoggedIn(0);

		$country = $this->locationRepository->findOneBy(array('id'=>$request->get('user_country')));
		$user->setCountry($country);
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


	public function populateEntity( $entity, $request )
	{
		$entity->setFirstname( $request->get('user_first_name') );
		$entity->setLastname( $request->get('user_last_name') );
		$entity->setContactnumber( $request->get('user_contact_number') );
		$entity->setEmail( $request->get('user_email') );
		$entity->setAddress( $request->get('user_address') );
		$entity->setCity( $request->get('user_city') );
		
		$country = $this->locationRepository->findOneBy(array('id'=>$request->get('user_country')));
		$entity->setCountry($country);

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


	public function validatePassword($password)
	{
		$user = $this->findById($this->securityContext->getIdentity()->getId());
		//$hashedPassword = hash('sha256',  $user->getSalt() . $password);
		if($user->getHashedPassword($password) != $user->getPassword()){
			throw new InvalidDataException('The current password did not match the one on file');
		}
		return;
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
		if($this->fetchUserInfo(array('username' => $username))){
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
		$user->setDateActivated(new \DateTime);
		$this->save($user);
		return true;
	}

	public function findUserByToken($token)
	{
		return $this->repository->findUserByToken($token);
	}
}
