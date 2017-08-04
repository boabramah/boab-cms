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
use Invetico\BankBundle\Repository\TransferRepositoryInterface;

class BankDashboardListener
{
	private $accountRepository;
	private $template;
	private $tokenStorage;
	private $transferRepository;

	public function __construct
	(
		AccountRepositoryInterface $accountRepository, 
		TransferRepositoryInterface $transferRepository,		
		TemplateInterface $template, 
		TokenStorageInterface $tokenStorage
	)
	{
		$this->accountRepository = $accountRepository;
		$this->transferRepository = $transferRepository;
		$this->template = $template;
		$this->tokenStorage = $tokenStorage;
	}

	public function onAppDashboard(DashboardEvent $event)
	{
		$customer = $this->tokenStorage->getToken()->getUser();
		//$userId = $this->tokenStorage->getToken()->getUser()->getId();
		
		$pendingBalance = $this->transferRepository->findTotalPendingTransfersByCustomerId($customer->getId());
		$totalBalance = $this->accountRepository->findCustomerTotalAccountBalanace($customer->getId());

		$this->template->bind('pendingTransfer',$this->getPendingTransferWidget($pendingBalance));		
		$this->template->bind('totalBalance', $this->getTotalAccountBalanceWidget($totalBalance));
		$this->template->bind('availableBalance', $this->getAvailableBalanceWidget($totalBalance - $pendingBalance));
		$this->template->bind('quickTransfer',$this->getQuickTransfer($customer));
	}

	private function getAvailableBalanceWidget($amount)
	{
		$view = $this->template->load('BankBundle:Account:available_balance');
		$view->amount = floatval($amount);
		return $view;
	}

	public function getPendingTransferWidget($amount)
	{
		$view = $this->template->load('BankBundle:Transfer:total_transfer_pending');
		$view->amount = floatval($amount);
		return $view;
	}	

	private function getTotalAccountBalanceWidget($totalBalance)
	{
		$view = $this->template->load('BankBundle:Account:total_balance_widget');
		$view->total_balance = $totalBalance;
		return $view;
	}

	private function getQuickTransfer($customer)
	{	
		$accounts = $this->accountRepository->findAccountByCustomerId($customer->getId());
		$view = $this->template->load('BankBundle:Transfer:quick_transfer');
		$view->accounts = $accounts;
		$view->transferDate = (new \DateTime('now'))->format('Y-m-d h:i:s');
		return $view->render()	;
	}

}