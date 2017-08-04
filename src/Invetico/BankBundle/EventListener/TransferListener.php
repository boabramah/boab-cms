<?php

namespace Invetico\BankBundle\EventListener;

use Invetico\BankBundle\Repository\AccountRepositoryInterface;
use Invetico\BoabCmsBundle\Event\DashboardEvent;
use Invetico\BoabCmsBundle\View\TemplateInterface;
use Invetico\UserBundle\Repository\UserRepositoryInterface;
use Invetico\BankBundle\Repository\TransferRepositoryInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class TransferListener
{
	private $userRepository;
	private $template;
	private $transferRepository;
	private $tokenStorage;

	public function __construct
	(
		UserRepositoryInterface $userRepository, 
		TemplateInterface $template, 
		TransferRepositoryInterface $transferRepository,
		TokenStorageInterface $tokenStorage
	)
	{
		$this->userRepository = $userRepository;
		$this->template = $template;
		$this->transferRepository = $transferRepository;
		$this->tokenStorage = $tokenStorage;
	}

	public function onAppDashboard(DashboardEvent $event)
	{
		$customer = $this->tokenStorage->getToken()->getUser();
		$this->template->bind('latestTransfer',$this->getLatestTransfer($customer->getId()));
	}


	public function getLatestTransfer($customerId)
	{
		$view = $this->template->load('BankBundle:Transfer:latest_transfer');
		$view->transfers = $this->transferRepository->findLatestTransfer($customerId, 3);
		return $view->render();
	}	

}