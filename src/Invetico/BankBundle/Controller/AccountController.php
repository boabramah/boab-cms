<?php

namespace Invetico\BankBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Invetico\BoabCmsBundle\Controller\BaseController;
use Invetico\BoabCmsBundle\Controller\InitializableControllerInterface;
use Invetico\BankBundle\Repository\AccountRepositoryInterface;
use Invetico\BankBundle\Model\AccountTypeManagerInterface;
use Invetico\BankBundle\Event\AccountCreatedEvent;
use Invetico\BankBundle\Entity\Account;
use Invetico\UserBundle\Repository\UserRepositoryInterface;
use Utils\AjaxJsonResponse;
use Invetico\BoabCmsBundle\Controller\AdminController;


Class AccountController extends AdminController implements InitializableControllerInterface
{
    private $userIdentity;
    private $accountRepository;
    private $userRepository;
    private $accountTypeManager;

    public function __Construct
    (
        AccountRepositoryInterface $accountRepository, 
        UserRepositoryInterface $userRepository, 
        AccountTypeManagerInterface $accountTypeManager
    ) 
    {
        $this->accountRepository = $accountRepository;
        $this->userRepository = $userRepository;
        $this->accountTypeManager = $accountTypeManager;         
    }

    public function initialize()
    {      
        $this->template->setTheme('jayle');
        $this->userIdentity = $this->securityContext->getIdentity();
    }

    public function indexAction(Request $request) 
    {
        $customer = $this->userRepository->findUserById($this->getUserToken()->getId());
        $accounts = $this->accountRepository->findAccountByCustomer($customer);
        $totalAccountBalance = $this->accountRepository->findCustomerTotalAccountBalanace($customer->getId());

        $view = $this->template->load('BankBundle:Account:accounts');
        $view->accounts = $accounts;
        $view->accountSummaryBalance = $totalAccountBalance;
        $view->generate = function($account){
            return $this->router->generate('account_view',['accountNumber'=>$account->getAccountNumber()]);
        };
        $this->template->setTitle('My Accounts')
             ->bind('page_header',$this->template->getTitle())
             ->bind('content',$view);
        return $this->template;
    }

    public function servicesAction(Request $request) 
    {
        $view = $this->template->load('BankBundle:Account:account_add');
        $view->generate = function($accountType){
            return $this->router->generate('account_services_add',['accountType'=>$accountType]);
        };
        $this->template->setTitle('Account Services')
             ->bind('page_header',$this->template->getTitle())
             ->bind('content',$view);
        return $this->template;
    }       

    public function addAccountAction(Request $request, $accountType=null) 
    {
        $account = $this->accountTypeManager->getAccountType($accountType);
        $this->eventDispatcher->dispatch('account.create', new AccountCreatedEvent($account));      

        $user = $this->entityManager->getReference('UserBundle:User', $this->getUserToken()->getId());

        $account->setAccountStatus('OPEN');
        $account->setBalance(0);
        $account->setDateCreated(new \DateTime('Now'));
        $account->setCustomer($user);

        $this->entityManager->persist($account);
        $this->entityManager->flush();

        $this->flash->setSuccess(sprintf('Account <strong>%s</strong> is added successfully', $account->getAccountName()));
        return $this->redirect($this->router->generate('account_services'));
    } 

    public function createAccountAction(Request $request, $accountType=null) 
    {

    }

    /*
     * @ParamConverter("account", class="BankBundle:Account", options={"mapping": {"accountNumber" = "accountNumber"}})
     */
    public function viewAccountAction(Request $request, Account $account)
    {
        if('POST' == $request->getMethod()){

            $accountName = $request->get('account_name');
            $account->setAccountName($accountName);

            $this->entityManager->persist($account);
            $this->entityManager->flush();
            $this->flash->setSuccess(sprintf('Account <strong>%s</strong> updated successfully', $account->getAccountName()));
            return $this->redirect($this->router->generate('account_view', ['accountNumber'=>$account->getAccountNumber()]));
        }
        $view = $this->template->load('BankBundle:Account:account_detail');
        $view->account = $account;
        $this->template->setTitle('Account')
             ->bind('page_header',$this->template->getTitle())
             ->bind('content',$view);
        return $this->template;        
    }
       
   
}
