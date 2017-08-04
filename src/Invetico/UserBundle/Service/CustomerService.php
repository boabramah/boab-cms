<?php

namespace Invetico\BankBundle\Service;


use Invetico\BankBundle\repository\CustomerRepositoryInterface;
use Invetico\BoabCmsBundle\Service\BaseService;
use Arrow\Validation\Exception\InvalidDataException;
use RandomLib\Factory as RandomGenerator;

Class CustomerService extends BaseService
{ 
	private $repository;
	private $randomGenerator;
	
	function __Construct(CustomerRepositoryInterface $repository, RandomGenerator $randomGenerator)
	{
		$this->repository = $repository;
		$this->randomGenerator = $randomGenerator;
	}

	public function create($request, $callback=null)
	{
		return parent::create($request, function($entity, $request){
			$entity->setDateCreated(new \DateTime);
			$entity->setUser($this->entityManager->getReference('Invetico\UserBundle\Entity\User', $this->securityContext->getIdentity()->getId()));

			$generator = $this->randomGenerator->getMediumStrengthGenerator();
			$entity->setCustomerId($generator->generateString(10, '0123456789'));
		});
	}


	public function update($user, $callback=null)
	{
		return parent::update($user, function($entity, $request){
		});
	}


	public function createEntity()
	{
		return new \Invetico\BankBundle\Entity\Customer;
	}

	public function createDeposit($request, $customer)
	{
		$deposit = new \Invetico\BankBundle\Entity\Payment();
		$deposit->setCustomer($customer);
		$deposit->setUser($this->entityManager->getReference('Invetico\UserBundle\Entity\User', $this->securityContext->getIdentity()->getId()));
		$deposit->setAmount($request->get('amount'));
		$deposit->setPaymentType($request->get('paymentType'));
		$deposit->setDateCreated( new \DateTime);

		$this->save($deposit);
		$this->entityManager->refresh($deposit);
		return $deposit;
	}

	public function dumpCustomer($records)
	{
		$entity = $this->createEntity();
		$entity->setAccountNumber(trim($records[0]));
		$entity->setAccountName(trim($records[1]));
		$entity->setContactnumber('');	
		$entity->setDateCreated(new \DateTime);
		$entity->setUser($this->entityManager->getReference('Invetico\UserBundle\Entity\User', $this->securityContext->getIdentity()->getId()));

		$generator = $this->randomGenerator->getMediumStrengthGenerator();
		$entity->setCustomerId($generator->generateString(10, '0123456789'));	
		$this->entityManager->persist($entity);		
	}


	public function populateEntity( $entity, $request )
	{
		$entity->setAccountNumber( $request->get('accountNumber') );
		$entity->setAccountName( $request->get('accountName') );
		$entity->setContactnumber( $request->get('contactNumber') );
		return $entity;
	}


	public function findById($id)
	{
		return $this->repository->findUserById($id);
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

	public function getManager()
	{
		return $this->entityManager;
	}


	public function deleteCustomers($customersIds)
	{
	    foreach($customersIds as $id){
	    	$customer = $this->entityManager->getReference('Invetico\BankBundle\Entity\Customer', $id);
        	$this->entityManager->remove($customer);
    	}
    	$this->entityManager->flush();
    }







}
