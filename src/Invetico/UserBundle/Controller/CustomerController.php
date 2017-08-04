<?php

namespace Invetico\BankBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Invetico\BoabCmsBundle\Controller\BaseController;
use Invetico\BoabCmsBundle\Controller\AccountPanelInterface;
use Invetico\BoabCmsBundle\Controller\InitializableControllerInterface;
use Invetico\BankBundle\Service\CustomerService;
use Invetico\BankBundle\Repository\CustomerRepositoryInterface;
use Utils\AjaxJsonResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Invetico\BoabCmsBundle\Controller\PublicControllerInterface;

Class CustomerController extends BaseController implements AccountPanelInterface, InitializableControllerInterface, PublicControllerInterface
{
    private $userService;
    private $userIdentity;
    private $customerService;
    private $customerRepository;
    private $files;
    private $allowedExt = ['csv','xls'];

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


    public function indexAction(Request $request) 
    {
        $collection = $this->customerRepository->findAll();
        $view = $this->template->load('BankBundle:Account:customers');
        $view->collection = $collection;
        $view->customersApiUrl = $this->urlGenerator->generate('api.customers');
        $view->generate = function($customer){
            return $this->urlGenerator->generate('api.customer_payment',['customerId'=>$customer->getCustomerId()]);
        };
        $view->generateEdit = function($customer){
            return $this->urlGenerator->generate('account.customer_update',['customerId'=>$customer->getCustomerId()]);
        };        
        $view->generateHistory = function($customer){
            return $this->urlGenerator->generate('account.customer_transactions',['customerId'=>$customer->getCustomerId()]);
        };         
        $view->deleteCustomersUrl = $this->urlGenerator->generate('api.customers_delete');
        $view->searchCustomersUrl = $this->urlGenerator->generate('api.customer_search');
        $this->template->setTitle('Customers')
             ->bind('page_header','Customers')
             ->bind('content',$view);
        return $this->template;
    }


    public function addAction(Request $request)
    {
        $action = $this->urlGenerator->generate('account.customer_add');

        if('POST' === $request->getMethod()){
            $validation = new \Invetico\BankBundle\Validation\Customer($request->request->all());
            if(!$validation->isValid()){
                
                if($request->isXmlHttpRequest()){
                    return new AjaxJsonResponse('error',$validation->getErrors());
                }

                $this->flash->setErrors($validation->getErrors());
                return $this->redirect($action);
            }
            try{
            $customer = $this->customerService->create($request);
            }catch(\Exception $e){
                $this->flash->setInfo($e->getMessage());
                return $this->redirect($action);
            }
            if($request->isXmlHttpRequest()){
                $response['message'] = sprintf('Customer <strong>%s</strong> recorded successfully', $customer->getAccountName());
                
                $makePaymentUrl = $this->urlGenerator->generate('api.customer_payment',['customerId'=>$customer->getCustomerId()]);
                $viewHistoryUrl = $this->urlGenerator->generate('account.customer_transactions',['customerId'=>$customer->getCustomerId()]);

                $response['customerData']['accountNumber'] = $customer->getAccountNumber();
                $response['customerData']['accountName'] = $customer->getAccountName();
                $response['customerData']['officer'] = $customer->getUser()->getFullName();
                $response['customerData']['makePayment'] = sprintf('<a class="ajax-customer-payment" href="%s">Make Payment</a>', $makePaymentUrl);
                $response['customerData']['viewHistory'] = sprintf('<a class="ajax-customer-history" href="%s">View History</a>', $viewHistoryUrl);
                return new AjaxJsonResponse('success',$response);
            }   

            $this->flash->setSuccess(sprintf('Customer <strong>%s</strong> created successfully', $customer->getAccountName()));
            //$this->eventDispatcher->dispatch('user.profile_updated',new ProfileUpdatedEvent($user));
            return $this->redirect($action);
        }

        $view = $this->template->load('BankBundle:Account:add_customer');
        //$view->collection = $collection;
        $view->action = $action;
        $view->flash = $this->flash;
        $this->template->setTitle('Add Customer')
             ->bind('page_header','Add Customer')
             ->bind('content',$view);
        return $this->template;       
    }

    public function updateAction(Request $request, $customerId)
    {
       
    }


    public function searchAction(Request $request)
    {
        $collection = $this->customerRepository->findAll();
        $view = $this->template->load('BankBundle:Account:customers_search');
        $view->collection = $collection;
        
        $view->searchCustomersUrl = $this->urlGenerator->generate('api.customer_search');
        $this->template->setTitle('Customers')
             ->bind('page_header','Customers')
             ->bind('content',$view);
        return $this->template;
    }

    private function getCustomersSearchView()
    {

    }


    public function batchloadAction(Request $request)
    {
        if('POST' === $request->getMethod()){
            $files = $request->files->all();
            $file = $files['customerBatchFile'];
            try{
                $this->validateFileType($file);
                $fo = fopen($file->getPathname(), "r");
                $entityManager = $this->customerService->getManager();
                while (($emapData = fgetcsv($fo, "", ",")) !== FALSE){
                    $this->customerService->dumpCustomer($emapData);
                    //print_r($emapData);
                }
                $entityManager->flush();                
            }catch(\InvalidArgumentException $e){
                die($e->getMessage());
            }
            /*
            $file = __DIR__.'/../customers.csv';
            $fo = fopen($file, "r"); // CSV fiile
            //$exportFile = __DIR__'/../export.txt';
            //$openFile = fopen($exportFile, 'a');
            $entityManager = $this->customerService->getManager();
            while (($emapData = fgetcsv($fo, "", ",")) !== FALSE){
                $this->customerService->dumpCustomer($emapData);
            }
            $entityManager->flush();
            */               
            exit; 
        
        }

        $view = $this->template->load('BankBundle:Account:batch_customer');
        $view->flash = $this->flash;
        $view->action = $this->urlGenerator->generate('account.customer_batchload');

        $this->template->setTitle("Batch Load Customer")
                    ->bind('page_header','Batch load Customer')
                    ->bind('content',$view);

        return $this->template;
    }

    protected function getFileUploaded($name)
    {
        return isset($this->files[$name]) ? $this->files[$name] : null;
    }

    public function upload(UploadedFile $file, $destination )
    {
        $image = $this->imagine->open($file->getPathname());
        $image->save($destination);
    }

    // Check if the file's mime type is in the list of allowed mime types.
    protected function validateFileType(UploadedFile $file)
    {
        if(!in_array($file->getClientOriginalExtension(), $this->allowedExt)){
            throw new \InvalidArgumentException(sprintf('The file extension %s is not allowed. Allowed ones are [%s]',$file->getClientOriginalExtension(), implode(',', $this->allowedExt)));
        }       
    }    



    public function sidebarMenu(Request $request)
    {
        $menuItems = [

            [
                'title'         =>'Add Customer',
                'route_name'    => 'api.customer_add',
                'class_name'    => 'add-customer-link'                
            ],

            [
                'title'         =>'Batchload Customer',
                'route_name'    => 'account.customer_batchload',
                'class_name'    => 'batch-load-customer'                
            ],                                   

        ];

        return $menuItems;
    }

}
