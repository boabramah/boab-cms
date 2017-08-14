<?php

namespace Invetico\MailerBundle\EventListener;

use Symfony\Component\EventDispatcher\Event;
use Invetico\UserBundle\Event\AccountRegisteredEvent;
use Invetico\MailerBundle\Form\Type\ContactType;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Invetico\BoabCmsBundle\View\Template;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class ContactFormListener
{
    private $template;
    private $twigTemplate;
    private $formFactory;

    public function __construct(Template $template, EngineInterface $twigTemplate, $formFactory)
    {
        $this->template = $template;
        $this->twigTemplate = $twigTemplate;
        $this->formFactory = $formFactory;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if($request->getPathInfo() != '/'){
            return;
        }
/*
        $form = $this->formFactory->create(new ContactType(),[]);
        $data['form'] = $form->createView();

        $view = $this->template->load('MailerBundle:Template:home_contact_container');
        $view->contactForm = $this->twigTemplate->render('MailerBundle:Template:home_contact_form.html.php',$data);
        $this->template->bind('contactFormWidget', $view->render(), true);
        */
    }   	


}

