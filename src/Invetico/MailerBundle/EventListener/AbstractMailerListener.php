<?php

namespace Invetico\MailerBundle\EventListener;

use Invetico\BoabCmsBundle\View\TemplateInterface;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractMailerListener
{
	protected $template;
	protected $mailer;
	protected $router;

	public function setDefault(TemplateInterface $template, $mailer, RouterInterface $router)
	{
		$this->template = $template;
		$this->mailer = $mailer;
		$this->router = $router;
	}

	protected function sendMail($subject, $fromEmail, $toEmail, $htmlContent)
	{
		$message = \Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom($fromEmail)
                ->setTo($toEmail)
                ->setBody($htmlContent, 'text/html')
                ->addPart(strip_tags($htmlContent), 'text/plain');
        return $this->mailer->send($message);
	}

	protected function fakeEmail($subject, $htmlContent)
	{
		$content = $this->template->load('MailerBundle:Message:register_email_template');
		$content->subject = $subject;
		$content->content = $htmlContent;
		echo $content->render();
		exit;		
	}

	protected function composeMail($subject, $fromEmail, $toEmail, $htmlContent)
	{
		$message = \Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom($fromEmail)
                ->setTo($toEmail)
                ->setBody($htmlContent, 'text/html')
                ->addPart(strip_tags($htmlContent), 'text/plain');
        return $message;		
	}
}