<?php

namespace Invetico\BankBundle\EventListener;

use Symfony\Component\EventDispatcher\Event;
use Invetico\BankBundle\Event\TransferAuthorizeEvent;
use Invetico\MailerBundle\EventListener\AbstractMailerListener;

class AuthorizationMailerListener extends AbstractMailerListener
{
	private $subject = 'Transfer Authorization Code';
	private $fromEmail;
	private $fromName = 'Logic Premium Bank';
	//private $template;

	public function __construct($fromEmail)
	{
		$this->fromEmail = $fromEmail;
	}

	public function onTransferAuthCode(TransferAuthorizeEvent $event)
	{
		//return;
		$customer = $event->getCustomer();
		$transfer = $event->getTransfer();
		
		$view = $this->template->load('BankBundle:Mail:authorization_message');
		$view->customer = $customer;
		$view->transfer = $transfer;
		//$view->activation_link = $this->router->generate('account_activate',['token'=>$customer->getRecentToken()], true);
		 
		//$this->fakeEmail(sprintf('Registration confirmation on %s', $this->fromName),$view->render());

		$this->sendMail(
		 		$this->subject, 
		 		[trim($this->fromEmail)=>$this->fromName], 
		 		[trim($customer->getEmail())=>$customer->getUsername()],
		 		$view->render()
		);
	}

}

