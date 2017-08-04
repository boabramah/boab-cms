<?php

namespace Invetico\MailerBundle\EventListener;

use Symfony\Component\EventDispatcher\Event;
use Invetico\UserBundle\Event\AccountRegisteredEvent;

class RegistrationConfirmationListener extends AbstractMailerListener
{
	private $subject = 'Please confirm your registration';
	private $fromEmail;
	private $fromName = 'Street Campaign 4 JM';

	public function __construct($fromEmail)
	{
		$this->fromEmail = $fromEmail;
	}

	public function onEmailConfirmation(AccountRegisteredEvent $event)
	{
		//return;
		$user = $event->getUser();
		$view = $this->template->load('MailerBundle:Message:message_email_confirmation');
		$view->user = $user;
		$view->activation_link = $this->router->generate('account_activate',['token'=>$user->getRecentToken()], true);
		 
		//$this->fakeEmail(sprintf('Registration confirmation on %s', $this->fromName),$view->render());

		$this->sendMail(
		 		$this->subject, 
		 		[trim($this->fromEmail)=>$this->fromName], 
		 		[trim($user->getEmail())=>$user->getUsername()],
		 		$view->render()
		);
	}

}

