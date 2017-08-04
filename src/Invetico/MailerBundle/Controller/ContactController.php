<?php

namespace Invetico\MailerBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Invetico\BoabCmsBundle\Controller\BaseController;
use Invetico\BoabCmsBundle\Controller\InitializableControllerInterface;
use Symfony\Cmf\Component\Routing\ChainRouter;
use Invetico\MailerBundle\Event\ContactFormSubmitedEvent;
use Invetico\MailerBundle\Form\Type\ContactType;
use Invetico\BoabCmsBundle\Controller\PublicControllerInterface;

class ContactController extends BaseController implements PublicControllerInterface, InitializableControllerInterface
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
        $this->template->setTheme('kantua');
    }


    public function contactAction(Request $request, $routeDocument=null)
    {
        $form = $this->createForm(new ContactType(),[]);
        $data['action'] = $this->router->generate($routeDocument);
        $data['form'] = $form->createView();
        $data['flash'] = $this->flash;

        $view = $this->template->load('MailerBundle:Template:contact_us');
        $view->contactForm = $this->renderView('MailerBundle:Template:contact_form_view.html.php',$data);

        $this->template->setTitle('Contact Us')
             ->bind('page_title', 'Contact us')
             ->bind('content',$view)
             ->setBlock('contentArea',$this->template->loadThemeBlock('kantua:plain_tpl'));
        return $this->template;
    }

    public function checkContactAction(Request $request, $routeDocument=null)
    {
        $contactForm = $this->createForm(new ContactType(), []);
        $contactForm->handleRequest($request);

        if($contactForm->isSubmitted() && !$contactForm->isValid()) {
            $this->flash->setErrors($this->getFormErrors($contactForm));
            return $this->redirect($this->router->generate('contact_us'), 301);
        }

        $data = $contactForm->getData();

        $contactEvent = new ContactFormSubmitedEvent();
        $contactEvent->setFullName($contactForm->get('fullName')->getData())
                     ->setEmail($contactForm->get('email')->getData())
                     ->setSubject($contactForm->get('subject')->getData())
                     ->setContactNumber($contactForm->get('contactNumber')->getData())
                     ->setMessage($contactForm->get('message')->getData());
        
        //$path = $this->appRoot.'/spool/attachments';
        //$outputFile = sprintf("%s/%s-%s-report.pdf",$path,Date('d-m-Y'),uniqid());
        //file_put_contents($outputFile, $this->printPdf($contactMessage));
        //$contactEvent->setAttachment($outputFile);



        $this->eventDispatcher->dispatch('contact.form_submited',$contactEvent);
        $this->flash->setSuccess('Message sent successfully');

        return $this->redirect($this->router->generate('contact_us'));        
    }


    private function getErrorMessages(\Symfony\Component\Form\Form $form) 
    {
        $errors = array();
        foreach ($form->getErrors() as $key => $error) {
            $template = $error->getMessageTemplate();
            $parameters = $error->getMessageParameters();

            foreach ($parameters as $var => $value) {
                $template = str_replace($var, $value, $template);
            }

            $errors[$key] = $template;
        }
        if ($form->count()) {
            foreach ($form as $child) {
                if (!$child->isValid()) {
                    $errors[$child->getName()] = $this->getErrorMessages($child);
                }
            }
        }
        return $errors;
    } 
 

    private function printPdf($content)
    {
        $dompdf = new \DOMPDF(); 
        $dompdf->set_paper("A4");  
        $dompdf->load_html($content);
        $dompdf->render();
        return $dompdf->output();         
        //$dompdf->stream(sprintf("%s-%s-report.pdf",Date('d-m-Y'),uniqid()));         
    }       

}
