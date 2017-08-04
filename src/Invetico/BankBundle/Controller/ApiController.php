<?php

namespace Invetico\BankBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Invetico\BoabCmsBundle\Controller\BaseController;
use Invetico\BoabCmsBundle\Controller\InitializableControllerInterface;
use Invetico\BankBundle\Repository\CustomerRepositoryInterface;
use Invetico\BankBundle\Repository\PaymentRepositoryInterface;
use Bundle\UserBundle\Repository\UserRepositoryInterface;
use Invetico\BankBundle\Entity\Payment;
use Invetico\BankBundle\Entity\Customer;
use Invetico\BankBundle\Api\Account\Account;
use Invetico\BankBundle\Api\Account\AccountCollection;
use Invetico\BankBundle\Api\OfficerTransaction\Payment as PaymentApi;
use Invetico\BankBundle\Api\OfficerTransaction\PaymentCollection;
use Invetico\BankBundle\Api\Officer\OfficerCollection;
use Invetico\BankBundle\Api\Officer\Officer;
use Utils\AjaxJsonResponse;

Class ApiController extends BaseController implements InitializableControllerInterface
{
    private $userIdentity;
    private $customerRepository;
    private $paymentRepository;
    private $userRepository;
    private $customerService;
    private $userService;

    CONST GROUP_BY_OFFICER = 'officer';
    CONST FORMAT_JSON = 'json';
    CONST FORMAT_PDF = 'pdf';
    CONST FORMAT_CSV = 'csv';
    CONST FORMAT_EXCEL = 'excel';

    public function __Construct
    (
        CustomerRepositoryInterface $customerRepository,
        PaymentRepositoryInterface $paymentRepository,
        UserRepositoryInterface $userRepository,
        $customerService,
        $userService
    ) 
    {
        $this->customerRepository = $customerRepository;
        $this->paymentRepository = $paymentRepository;
        $this->userRepository = $userRepository;
        $this->customerService = $customerService;     
        $this->userService = $userService;     
    }


    public function initialize()
    {      
        $this->userIdentity = $this->securityContext->getIdentity();
    }


    public function indexAction(Request $request) 
    {
        $accountCollection = new AccountCollection();
        $collection = $this->customerRepository->findAll();
        foreach($collection as $account){
            $accountCollection->addAccount($this->getAccountApi($account));            
        }
        return $this->getJsonResponse($accountCollection);
    }


    public function addCustomerAction(Request $request)
    {
        $action = $this->urlGenerator->generate('api.customer_add');
        $validation = new \Invetico\BankBundle\Validation\Customer($request->request->all());
        if(!$validation->isValid()){
            return new AjaxJsonResponse('error',$validation->getErrors());
        }
        $account = $this->customerService->create($request);   
        $response = new AjaxJsonResponse('success',sprintf('Customer <strong>%s</strong> created successfully', $account->getAccountName()));
        $response->setData($this->getAccountApi($account));
        return $response;
    }


    public function searchCustomerAction(Request $request)
    {
        $searchTerm = $request->get('customer_search_field');
        $accountCollection = new AccountCollection();
        if(empty($searchTerm)){
            return $this->getJsonResponse($accountCollection);
        }
        $collection = $this->customerRepository->findCustomerBySearchCriteria($searchTerm);
        foreach($collection as $account){
            $accountCollection->addAccount($this->getAccountApi($account));            
        }
        return $this->getJsonResponse($accountCollection);        
    }


    public function fetchCustomerAction(Request $request, $customerId)
    {
        $account = $this->customerRepository->findOneBy(['customerId'=>$customerId]);
        return $this->getJsonResponse($this->getAccountApi($account));
    }


    public function updateCustomerAction(Request $request, $customerId)
    {
        $customer = $this->customerRepository->findOneBy(['customerId'=>$customerId]);
        if('POST' === $request->getMethod()){
            $validation = new \Invetico\BankBundle\Validation\Customer($request->request->all());
            if(!$validation->isValid()){
                $ajaxResponse = new AjaxJsonResponse('error',$validation->getErrors());
                $ajaxResponse->setData($this->getAccountApi($customer));
                return $ajaxResponse;
            }
            
            $this->customerService->update($customer, $request);

            $message = sprintf('Customer <strong>%s</strong> update successfully', $customer->getAccountName());
            return new AjaxJsonResponse('success',$message);
        }        
    }


    public function customerPaymentAction(Request $request, $customerId)
    {
        $customer = $this->customerRepository->findOneBy(['customerId'=>$customerId]);
        if('POST' === $request->getMethod()){

            $validation = new \Invetico\BankBundle\Validation\Deposit($request->request->all());
            if(!$validation->isValid()){
                $ajaxResponse = new AjaxJsonResponse('error',$validation->getErrors());
                $ajaxResponse->setData($this->getAccountApi($customer));
                return $ajaxResponse;
            }
            $deposit = $this->customerService->createDeposit($request, $customer);
            if($deposit instanceof Payment){
                return new AjaxJsonResponse('success','Payment recorded successfully');
            }
        }
        return new AjaxJsonResponse('error','Unable to record customer payments. Please try again');       
    }


    /*
     * @ParamConverter("customer", class="BankBundle:Customer", options={"mapping": {"customerId" = "customerId"}})
     */

    public function customerTransactionsAction(Request $request, Customer $customer)
    {
        $view = $this->template->load('BankBundle:Account:customer_transactions_ajax');
        $view->customer = $customer;

        $payments = $this->paymentRepository->findAllCustomerPayments($customer->getCustomerId());
        $view->payments = $this->getPaymentApiResponse($payments);
        return new Response($view->render());
    }  


    private function getAccountApi($account)
    {
        $apiAccount = new Account($account);
        $apiAccount->setMakePaymentUrl($this->urlGenerator->generate('api.customer_payment',['customerId'=>$account->getCustomerId()]));
        $apiAccount->setAccountTransactionUrl($this->urlGenerator->generate('api.customer_transactions',['customerId'=>$account->getCustomerId()]));
        $apiAccount->setAccountDetailUrl($this->urlGenerator->generate('api.customer_fetch',['customerId'=>$account->getCustomerId()]));
        $apiAccount->setUpdateAccountUrl($this->urlGenerator->generate('api.customer_update',['customerId'=>$account->getCustomerId()]));        
        $apiAccount->setDeleteAccountUrl($this->urlGenerator->generate('api.customer_delete',['customerId'=>$account->getCustomerId()]));        
        return $apiAccount;
    }


    public function deleteCustomerAction(Request $request)
    {
        //$customerId = $request->get('customerId');
        exit(__METHOD__);
    }

    public function deleteBatchCustomersAction(Request $request)
    {
        $selectedCustomersIds = $request->get('selected_customers');
        if(empty($selectedCustomersIds)){
            return;
        }
        if(!$this->securityContext->hasRole('ROLE_SUPER_ADMIN')){
            return new AjaxJsonResponse('error','Insufficient roles to perform this action');
        }
        //echo get_class($this->userIdentity);
        $this->customerService->deleteCustomers($selectedCustomersIds);
        return new AjaxJsonResponse('success',sprintf('%s account deleted successfully', count($selectedCustomersIds)));
    }


    public function suspendOfficersAction(Request $request)
    {
        $selectedOfficers = $request->get('selected_officers');
        if(!$this->securityContext->hasRole('ROLE_SUPER_ADMIN')){
            return new AjaxJsonResponse('error','Insufficient roles to perform this action');
        }

        foreach($selectedOfficers as $id){
            $this->userService->suspend($id);
        }
        return new AjaxJsonResponse('success',sprintf('%s officers suspended successfully', count($selectedOfficers)));      
    }


    public function transactionsAction(Request $request, $format)
    {
        $startDate = $request->get('start_date');
        if(empty($startDate)){
            $startDate = Date('d-m-Y');
        }
        $endDate = $request->get('end_date');
        $collection = $this->paymentRepository->findAllPayments($this->toDateTime($startDate), $this->toDateTime($endDate));
        return $this->getJsonResponse($this->getPaymentApiResponse($collection));
    }
    

    public function deleteTransactionAction(Request $request)
    {
        if(!$this->securityContext->hasRole('ROLE_SUPER_ADMIN')){
            return new AjaxJsonResponse('error','Insufficient roles to perform this action');
        }

        $selectedTransacts = $request->get('selected_transact');
        $em = $this->paymentRepository->getEntityManager();
        foreach($selectedTransacts as $id){
            $payment = $em->getReference('Invetico\BankBundle\Entity\Payment', $id);
            $em->remove($payment);
        }
        $em->flush();        

        //echo get_class($this->userIdentity);
        //$this->customerService->deleteCustomers($selectedCustomersIds);
        return new AjaxJsonResponse('success',sprintf('%s transaction deleted successfully', count($selectedTransacts)));        
    }


    public function transactionsReportAction(Request $request, $format)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $groupBy = $request->get('group_by');
        if(empty($groupBy)){
            $collection = $this->paymentRepository->findAllPayments($this->toDateTime($startDate), $this->toDateTime($endDate));            
            $this->printPdf($this->getPaymentView($collection)->render());
        }

        if($groupBy == self::GROUP_BY_OFFICER){
            $collection = $this->paymentRepository->findTotalAmountByOfficersPayments($this->toDateTime($startDate), $this->toDateTime($endDate));

            $officerCollection = new OfficerCollection();
            foreach($collection as $key => $value){
                $officerApi = new Officer($value);
                $officerCollection->addOfficer($officerApi);
            }

            $view = $this->template->load('BankBundle:Account:report_officers');
            $view->collection = $officerCollection;

            $this->printPdf($view->render());
        }
        exit;

    }


    public function officerTransactionAction(Request $request, $officerId, $format)
    {
        $officerId = $request->get('officerId');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date'); 

        $nolimit = $request->get('_nolimit');
        if(!$nolimit){
            $collection = $this->paymentRepository->findOfficerPayments($officerId, $this->toDateTime($startDate), $this->toDateTime($endDate), 50);
        }else{
            $collection = $this->paymentRepository->findOfficerPayments($officerId, $this->toDateTime($startDate), $this->toDateTime($endDate));            
        }

        

         $this->summaryPayment($collection);

        $officer = $this->userRepository->findUserById($officerId);
        
        if($format == self::FORMAT_JSON){
            return $this->getJsonResponse($this->getPaymentApiResponse($collection));
        }
        if($format == self::FORMAT_PDF){
            $view = $this->getPaymentView($collection);
            $view->officer = $officer;
            $view->date = $this->toDateTime($startDate)->format('d/m/Y');
            $view->paymentsSummary = $this->summaryPayment($collection);
            $this->printPdf($view->render());

        }

        if($format == self::FORMAT_CSV || $format == self::FORMAT_EXCEL){
            $this->exportTransactionAction($collection, $format);
        }

    }  

    private function summaryPayment($collection) 
    {
        $paymentType = [];
        foreach(array_keys(paymentTypeCodes()) as $code){
            $paymentType[$code] = [];
        }
        foreach($collection as $payment){
            $paymentType[$payment->getPaymentType()][] = $payment->getAmount();
        }

        $totals = [];
        foreach($paymentType as $key => $value){
            $totals[$key] = array_sum($value);
        }
        //print_r($totals);
        //exit;

        return $totals;
    }
    

    public function reportAction(Request $request, $format)
    {    
        $officerId = $request->get('officerId');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $records = $this->paymentRepository->findOfficerPayments($officerId, $this->toDateTime($startDate), $this->toDateTime($endDate));
        $this->printPdf($this->getPaymentView($records)->render());
    }


    private function getPaymentView($collection)
    {
        $collection = $this->getPaymentApiResponse($collection);
        $view = $this->template->load('BankBundle:Account:report');
        $view->collection = $collection;
        return $view;        
    }


    private function printPdf($content)
    {
        $dompdf = new \DOMPDF(); 
        $dompdf->set_paper("A4");  
        $dompdf->load_html($content);
        $dompdf->render();
        $dompdf->stream(sprintf("%s-%s-report.pdf",Date('d-m-Y'),uniqid()));         
    }

    private function getPaymentApiResponse($collection)
    {
        $paymentCollection = new PaymentCollection();
        foreach($collection as $payment){
            $apiPayment = new PaymentApi($payment);
            $apiPayment->setPaymentType(paymentType($payment->getPaymentType()));
            $paymentCollection->addPayment($apiPayment);
        }
        return $paymentCollection;      
    }


    public function exportTransactionAction($records, $format)
    {
        $data = $this->getFormatedPaymentRecords($records);                     
        switch ($format) {               
            case "excel" :                  
                $filename = 'data' . ".xls";       
                header("Content-Type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename=\"$filename\"");
                $this->ExportFile( $data);
                exit;

            case "csv" :
                $data = $this->getFormatedPaymentRecords($records);
                $filename = 'data' . ".csv";       
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("Content-type: text/csv");
                header("Content-Disposition: attachment; filename=\"$filename\"");
                header("Expires: 0");
                $this->ExportCSVFile( $data);
                exit;
            default :
        }  
    } 


    function ExportCSVFile($records) 
    {
        // create a file pointer connected to the output stream
        $fh = fopen( 'php://output', 'w' );
        $heading = false;
            if(!empty($records))
              foreach($records as $row) {
                if(!$heading) {
                  // output the column headings
                  fputcsv($fh, array_keys($row));
                  $heading = true;
                }
                // loop over the rows, outputting them
                 fputcsv($fh, array_values($row));
                 
              }
              fclose($fh);
    }

    function ExportFile($records) 
    {
        $heading = false;
        if(!empty($records))
          foreach($records as $row) {
            if(!$heading) {
              // display field/column names as a first row
              echo implode("\t", array_keys($row)) . "\n";
              $heading = true;
            }
            echo implode("\t", array_values($row)) . "\n";
          }
        //exit;
    }


    private function getFormatedPaymentRecords($payments)
    {
        $data = [];
        foreach($payments as $payment){
           $data[] = [
                'No'=>'',
                'Account Number'=>$payment->getCustomer()->getAccountNumber(),
                'Balance'=>'',
                'Nominal'=>'',
                'Description'=>$payment->getCustomer()->getAccountName(),
                'Details'=>$payment->getPaymentType(),
                'Chq No'=>'',
                'Debit'=>'',
                'Credit'=>$payment->getAmount()
            ];
        }

        return $data;
    }     
}
