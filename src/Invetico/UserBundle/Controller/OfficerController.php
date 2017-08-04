<?php

namespace Invetico\BankBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Invetico\BoabCmsBundle\Controller\BaseController;
use Invetico\BoabCmsBundle\Controller\AccountPanelInterface;
use Invetico\BoabCmsBundle\Controller\InitializableControllerInterface;
use Invetico\BankBundle\Service\CustomerService;
use Invetico\BankBundle\Repository\CustomerRepositoryInterface;
use Invetico\BankBundle\Entity\Customer;
use Invetico\BankBundle\Entity\Payment;
use Invetico\BankBundle\repository\OfficerRepositoryInterface;
use Invetico\UserBundle\Entity\User;
use Invetico\BankBundle\Repository\PaymentRepositoryInterface;
use Bundle\UserBundle\Event\AccountRegisteredEvent;
use Invetico\BoabCmsBundle\Controller\PublicControllerInterface;


Class OfficerController extends BaseController implements AccountPanelInterface, InitializableControllerInterface, PublicControllerInterface
{
    private $officerRepository;
    private $paymentRepository;
    private $userService;

    public function __Construct
    (
        OfficerRepositoryInterface $officerRepository, 
        PaymentRepositoryInterface $paymentRepository,
        $userService
    ) 
    {
        $this->officerRepository = $officerRepository;
        $this->paymentRepository = $paymentRepository;
        $this->userService = $userService;
    }


    public function initialize()
    {
        $this->template->setTheme('wooli');
        $this->template->setBlock('contentArea',$this->template->loadThemeBlock('wooli:control_panel_tpl'));
        $this->userIdentity = $this->securityContext->getIdentity();
    }

    public function indexAction(Request $request)
    {
        $collection = $this->officerRepository->findAllOfficers(1);
        $view = $this->template->load('BankBundle:Account:Officers');
        $view->collection = $collection;
        $view->generate = function($user){
            return $this->urlGenerator->generate('win.officer_transactions',['officerId'=>$user->getId()]);
        };  
        $view->suspendOfficerUrl = $this->urlGenerator->generate('api.officers_suspend');
        $view->deleteOfficerUrl = $this->urlGenerator->generate('api.officers_delete');
        
        $this->template->setTitle('Officers')
             ->bind('page_header','Officers')
             ->bind('content',$view);
        return $this->template;
    }


    public function addAction(Request $request)
    {
        $url = $this->urlGenerator->generate('win.officers_add');

        if('POST' === $request->getMethod()){

            $validation = new \Bundle\UserBundle\Validation\RegisterForm($request->request->all());
            $validation->delegate('username',array($this->userService,'validateUsername'));
            $validation->delegate('email',array($this->userService,'validateEmail'));

            if(!$validation->isValid()){
                $this->flash->setErrors($validation->getErrors());
                $this->flash->setValues($request->request->all());
                return $this->redirect($url);
            }
            $user = $this->userService->register($request);

            $this->eventDispatcher->dispatch('user.account_registered',new AccountRegisteredEvent($user));
            return $this->redirect($this->urlGenerator->generate('user.account_verification'));
        }

        //$country = $this->locationService->findLocationBySlugWidthChildren($request->get('_sub_domain'));
        $view = $this->template->load('BankBundle:Account:register_officer');
        $view->action = $url;
        $view->login = $this->urlGenerator->generate('_login');
        $view->country = $request->get('_country');
        $view->flash = $this->flash;
        $this->template->setTitle('Registration')
                     ->bind('content',$view)
             ->bind('page_header','Create Officer');
        return $this->template;
    }


    public function transactionsAction(Request $request)
    {
        if($this->authorizationChecker->isGranted('ROLE_SUPER_ADMIN')){

        }    

        $view = $this->template->load('BankBundle:Account:officers_transactions');
        $view->transactionsUrl = $this->urlGenerator->generate('api.officers_transactions',['format'=>'json']);
        $view->generateReportUrl = function($format){
            return $this->urlGenerator->generate('api.officers_report',['format'=>$format]);
        };
        $view->groupByOfficerUrl = $this->urlGenerator->generate('api.officers_report',['format'=>'pdf', 'group_by'=>'officer']);
        $view->deleteTransactionUrl = $this->urlGenerator->generate('api.delete_transactions');

        $this->template->setTitle('Officer')
             ->bind('page_header','Transactions')
             ->bind('content',$view);
        return $this->template;        
    }     


    public function officerTransactionsAction(Request $request, $officerId='')
    {
        $view = $this->template->load('BankBundle:Account:officer_transactions');
        $view->apiOfficerTransactionsUrl = $this->urlGenerator->generate('api.officer_transactions',['officerId'=>$officerId,'format'=>'json']);
        $view->generateReportUrl = function($format)use($officerId){
            return $this->urlGenerator->generate('api.officer_transactions',['format'=>$format,'officerId'=>$officerId]);
        };
        $this->template->setTitle('Officer')
             ->bind('page_header','Transactions')
             ->bind('content',$view);
        return $this->template;        
    } 
 


    public function sidebarMenu(Request $request)
    {
        $menuItems = [
            [
                'title'         =>'Create Officer',
                'route_name'    => 'win.officers_add',                
            ],
        ];

        return $menuItems;
    }

}
