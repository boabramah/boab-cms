<?php
namespace Invetico\MailerBundle\EventListener;

use Invetico\UserBundle\Entity\User;
use Invetico\MailerBundle\Event\ContactFormSubmitedEvent;

class DirectContactMailListener extends AbstractMailerListener
{
	private $subject = 'Contact Form Message';
	private $fromEmail;
	private $fromName = 'Contact Form';
	private $toEmail;
	private $toName = 'Information';

	public function __construct($fromEmail, $toEmail)
	{
		$this->fromEmail = $fromEmail;
		$this->toEmail = $toEmail;
	}

	public function onContactFormSubmitted(ContactFormSubmitedEvent $event)
	{
		$content = $this->template->load('MailerBundle:Message:contact_message');
		$content->fullName = $event->getFullName();
		$content->email = $event->getEmail();
		$content->contactNumber = $event->getContactNumber();
		$content->message = $event->getMessage();
		//$content->organisation = $event->getOrganisation();

		$message = $this->composeMail(
			sprintf('A message from %s',$event->getFullName()),
			array($this->fromEmail=>$this->fromName),
			array(trim($this->toEmail)=>$this->toName),
			$content->render()
		);

		if($event->getAttachment()){
			$attachment = \Swift_Attachment::fromPath($event->getAttachment())->setDisposition('inline');
			$message->attach($attachment);
		}
		$this->mailer->send($message);
	}

}