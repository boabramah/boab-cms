<?php

namespace Invetico\BankBundle\EventListener;

use RandomLib\Generator as RandomGenerator;
use Invetico\BankBundle\Event\AccountCreatedEvent;
use Invetico\BankBundle\Event\TransferCreatedEvent;
use Invetico\BankBundle\Repository\AccountRepositoryInterface;
use Invetico\BoabCmsBundle\Event\DashboardEvent;
use Invetico\BoabCmsBundle\View\TemplateInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Invetico\BankBundle\Entity\DomesticTransferInterface;

class BankEventListener
{
	private $accountRepository;
	private $template;
	private $randomGenerator;
	private $tokenStorage;

	public function __construct
	(
		AccountRepositoryInterface $accountRepository, 
		TemplateInterface $template, 
		RandomGenerator $randomGenerator,
		TokenStorageInterface $tokenStorage
	)
	{
		$this->accountRepository = $accountRepository;
		$this->template = $template;
		$this->randomGenerator = $randomGenerator;
		$this->tokenStorage = $tokenStorage;
	}

	public function onAppDashboard(DashboardEvent $event)
	{
		$customer = $this->tokenStorage->getToken()->getUser();
		//$this->template->bind('pendingTransfer',$this->getPendingTransfer());
		//$this->template->bind('totalBalance', $this->getTotalAccountBalanceWidget($customer));
	}


	function onAccountCreatedEvent(AccountCreatedEvent $event)	
	{
		$number = $this->randomGenerator->generateString(12, '0123456789');
		$account = $event->getAccount();
        $account->setAccountNumber($number); 
        $event->setAccount($account);
	}

	function onTransferCreatedEvent(TransferCreatedEvent $event)	
	{
		$number = $this->randomGenerator->generateString(8, '0123456789');
		$transfer = $event->getTransfer();
        $transfer->setReferenceNumber($number);
        
        if($transfer instanceof DomesticTransferInterface){
        	$code = $this->randomGenerator->generateString(6, '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ');
        	$transfer->setAuthorizationCode($code);
        }
        $event->setTransfer($transfer);
	}
}