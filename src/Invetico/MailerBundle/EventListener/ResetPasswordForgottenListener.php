<?php

namespace Invetico\MailerBundle\EventListener;


use Invetico\UserBundle\Event\PasswordForgottenEvent;

class ResetPasswordForgottenListener extends AbstractMailerListener
{
    private $subject = 'Reset Password';
    private $fromEmail;
    private $fromName = 'Street Campaign 4 JM';

    public function __construct($fromEmail)
    {
        $this->fromEmail = $fromEmail;
    }

    public function onMailPasswordForgotten(PasswordForgottenEvent $event)
    {
        $user = $event->getUser();
        $view = $this->template->load('MailerBundle:Message:password_reset_message');
        $view->user = $user;
        $view->passwordResetLink = $this->router->generate('password_reset',['token'=>$user->getRecentToken()], true);

        $this->sendMail(
                 'Please reset your password', 
                 [trim($this->fromEmail)=>$this->fromName], 
                 [trim($user->getEmail())=>$user->getUsername()],
                 $view->render()
             );
    }

}