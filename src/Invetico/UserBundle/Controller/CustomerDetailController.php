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
use Utils\AjaxJsonResponse;

Class CustomerDetailController extends BaseController implements AccountPanelInterface, InitializableControllerInterface
{
    private $userService;
    private $userIdentity;
    private $customerService;
    private $customerRepository;

    public function __Construct
    (
        CustomerService $customerService, 
        CustomerRepositoryInterface $customerRepository
    ) 
    {
        $this->customerService = $customerService;
        $this->customerRepository = $customerRepository;
    }


    public function initialize()
    {
        $this->template->setTheme('wooli');
        $this->template->setBlock('contentArea',$this->template->loadThemeBlock('wooli:control_panel_tpl'));
        $this->template->bind('script_files',$this->asset->script(['profile_script']));
        $this->userIdentity = $this->securityContext->getIdentity();
    }

    /*
     * @ParamConverter("customer", class="BankBundle:Customer", options={"mapping": {"customerId" = "customerId"}})
     */
    public function customerInfoAction(Request $request, Customer $customer) 
    {
        $view = $this->template->load('BankBundle:Account:customer_info');
        $view->customer = $customer;
        $this->template->setTitle('Customer Infomation')
             ->bind('page_header',$customer->getAccountName())
             ->bind('content',$view);
             //->setBlock('contentArea', $this->template->loadBlock('UserBundle:Account:account_dashboard_tpl'),true);
        return $this->template;
    }
    
    /*
     * @ParamConverter("customer", class="BankBundle:Customer", options={"mapping": {"customerId" = "customerId"}})
     */
    public function transactionAction(Request $request, Customer $customer)
    {
        $view = $this->template->load('BankBundle:Account:customer_transactions');
        $view->customer = $customer;

        if($request->isXmlHttpRequest()){
            $view->load('BankBundle:Account:customer_transactions_ajax');
            return new Response($view->render());            
        }

        $this->template->setTitle('Transaction History')
             ->bind('page_header',$customer->getAccountName())
             ->bind('content',$view);
        return $this->template;
    }

    /*
     * @ParamConverter("customer", class="BankBundle:Customer", options={"mapping": {"customerId" = "customerId"}})
     */
    public function depositAction(Request $request, Customer $customer)
    {
        $action = $this->urlGenerator->generate('account.customer_deposit', ['customerId'=>$customer->getCustomerId()]);
        
        if('POST' === $request->getMethod()){

            $validation = new \Invetico\BankBundle\Validation\Deposit($request->request->all());
            if(!$validation->isValid()){
                if($request->isXmlHttpRequest()){
                    return new AjaxJsonResponse('error',$validation->getErrors());
                }
                $this->flash->setErrors($validation->getErrors());
                return $this->redirect($action);
            }
            $deposit = $this->customerService->createDeposit($request, $customer);
            if($deposit instanceof Payment){
                if($request->isXmlHttpRequest()){
                    return new AjaxJsonResponse('success','Payment recorded successfully');
                }                
                $this->flash->setSuccess('Payment recorded successfully');
            }
            return $this->redirect($this->urlGenerator->generate('account.customer_deposit',['customerId'=>$customer->getCustomerId()]));
        }

        $view = $this->template->load('BankBundle:Account:make_deposit');
        $view->flash = $this->flash; 
        $view->action = $action;
        $view->customer = $customer;

        if($request->isXmlHttpRequest()){
            $view->load('BankBundle:Account:make_deposit_ajax');
            return $this->getJsonResponse($customer);            
        }

        $this->template->setTitle('Deposit')
             ->bind('page_header',$customer->getAccountName())
             ->bind('content', $view);
        return $this->template;
    }    



    public function sidebarMenu(Request $request)
    {
        $menuItems = [

            [
                'title'         =>'Customer Info',
                'route_name'    => 'account.customer_view',
                'route_param' => ['customerId'=>$request->get('customerId')]
            ], 
            [
                'title'         =>'Make Payment',
                'route_name'    => 'account.customer_deposit',
                'route_param' => ['customerId'=>$request->get('customerId')]
            ],                       
            [
                'title'         =>'Transaction History',
                'route_name'    => 'account.customer_transactions',
                'route_param' => ['customerId'=>$request->get('customerId')]
            ],

        ];

        return $menuItems;
    }

}
