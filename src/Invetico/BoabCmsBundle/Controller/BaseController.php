<?php

namespace Invetico\BoabCmsBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Invetico\BoabCmsBundle\Entity\ContentInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Invetico\BoabCmsBundle\View\TemplateInterface;
use Invetico\BoabCmsBundle\Library\Pagination;
use Symfony\Component\Form\Form;
use Invetico\BoabCmsBundle\Library\Flash;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Invetico\BoabCmsBundle\Validation\ValidationInterface;


abstract class BaseController
{
    protected $template;
    protected $flash;
    protected $session;
    protected $router;
    protected $pagination;
    protected $formFactory;
    protected $authorizationChcker;
    protected $tokenStorage;
    protected $validation;
    protected $entityManager;
    protected $eventDispatcher;

    public function initialize()
    {
        //$this->userIdentity = $this->securityContext->getIdentity();
    }

    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function setTemplate(TemplateInterface $template)
    {
        $this->template = $template;
    }

    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
    } 

    public function setFlash(Flash $flash)
    {
        $this->flash = $flash;
    }

    public function setSession($session)
    {
        $this->session = $session;
    } 

    public function setAuthorizationChecker(AuthorizationCheckerInterface $authorizationChcker)
    {
        $this->authorizationChcker = $authorizationChcker;
    }

    public function setTokenStorage(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function redirect($url, $status = 302)
    {
        return new RedirectResponse($url);
    }

    public function getJsonResponse($message)
    {
        $response = $this->getResponse(json_encode($message));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function setRouter(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function setPagination(Pagination $pagination)
    {
        $this->pagination = $pagination;
    }

    /**
     * Returns a rendered view.
     *
     * @param string $view       The view name
     * @param array  $parameters An array of parameters to pass to the view
     *
     * @return string The rendered view
     */
    public function renderView($view, array $parameters = array())
    {
        return $this->twigTemplate->render($view, $parameters);
    }    

    /**
     * Renders a view.
     *
     * @param string   $view       The view name
     * @param array    $parameters An array of parameters to pass to the view
     * @param Response $response   A response instance
     *
     * @return Response A Response instance
     */
    public function render($view, array $parameters = array(), Response $response = null)
    {
        return $this->twigTemplate->renderResponse($view, $parameters, $response);
    }  

    /**
     * Creates and returns a Form instance from the type of the form.
     *
     * @param string|FormTypeInterface $type    The built type of the form
     * @param mixed                    $data    The initial data for the form
     * @param array                    $options Options for the form
     *
     * @return Form
     */
    protected function createForm($type, $data = null, array $options = array())
    {
        return $this->formFactory->create($type, $data, $options);
    }
    /**
     * Creates and returns a form builder instance.
     *
     * @param mixed $data    The initial data for the form
     * @param array $options Options for the form
     *
     * @return FormBuilder
     */
    protected function createFormBuilder($data = null, array $options = array())
    {
        return $this->formFactory->createBuilder('form', $data, $options);
    }      

    protected function getFormErrors(Form $form, $flip=true)
    {
        $errors = array();
        foreach ($form as $fieldName => $formField) {
            foreach ($formField->getErrors($flip) as $error) {
                $errors[$fieldName] = $error->getMessage();
            }
        }
        return $errors;       
    }

    protected function getUserToken()
    {
        return $this->tokenStorage->getToken()->getUser();
    }

    public function setValidation(ValidationInterface $validation)
    {
        $this->validation = $validation;
    }

    protected function generateAsset($asset, $schemeAndHttpHost=true)
    {
        $baseUrl = $this->router->generate('site_root',[],$schemeAndHttpHost);
        return $baseUrl.$asset;
    }
      
}