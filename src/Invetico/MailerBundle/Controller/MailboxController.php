<?php

namespace Invetico\MailerBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Invetico\BoabCmsBundle\Controller\BaseController;
use Invetico\BoabCmsBundle\Controller\InitializableControllerInterface;
use Symfony\Cmf\Component\Routing\ChainRouter;
use Invetico\MailerBundle\Event\ContactFormSubmitedEvent;
use Invetico\MailerBundle\Form\Type\ContactType;
use Invetico\BoabCmsBundle\Controller\PublicControllerInterface;

class MailboxController extends BaseController implements PublicControllerInterface, InitializableControllerInterface
{
    protected $router;
    private $appRoot;

    public function __construct(ChainRouter $router, $appRoot)
    {
        $this->router = $router;
        $this->appRoot = $appRoot;
    }

    public function initialize()
    {
        $this->template->setTheme('jayle');
    }


    public function inboxAction(Request $request)
    {
        $view = $this->template->load('MailerBundle:Mailbox:inbox');

        $this->template->setTitle('Inbox')
             ->bind('page_title', $this->template->getTitle())
             ->bind('content',$view);
        return $this->template;        
    }    

    public function composeAction(Request $request)
    {
        $view = $this->template->load('MailerBundle:Mailbox:compose');

        $this->template->setTitle('Compose')
             ->bind('page_title', $this->template->getTitle())
             ->bind('content',$view);
        return $this->template;        
    }


}
