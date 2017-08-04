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
use Invetico\BankBundle\Exception\InsufficientFundException;
use Invetico\BankBundle\Entity\CreditTransaction;
use Invetico\BankBundle\Entity\DebitTransaction;


Class AdminAccountController extends AdminController implements InitializableControllerInterface
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
        $accounts = $this->accountRepository->findAll();
        $totalAccountBalance = $this->accountRepository->findCustomerTotalAccountBalanace($customer->getId());

        $view = $this->template->load('BankBundle:Account:admin_accounts');
        $view->accounts = $accounts;
        $view->accountSummaryBalance = $totalAccountBalance;
        $view->generate = function($account){
            return $this->router->generate('admin_account_view',['accountNumber'=>$account->getAccountNumber()]);
        };
        $this->template->setTitle('Admin')
             ->bind('page_header',$this->template->getTitle())
             ->bind('content',$view);
        return $this->template;
    }

    /*
     * @ParamConverter("account", class="BankBundle:Account", options={"mapping": {"accountNumber" = "accountNumber"}})
     */
    public function depositAction(Request $request, Account $account) 
    {
        if('POST' === $request->getMethod()){
            try{
                $transaction = new CreditTransaction;
                $transaction->setDateCreated(new \DateTime('now'));
                $transaction->setDescription($request->get('description'));
                $transaction->setAmount($request->get('amount'));
                $transaction->setAccount($account);

                $this->entityManager->persist($transaction);
                $this->entityManager->flush();
            }catch(InsufficientFundException $e){
                $this->flash->setInfo($e->getMessage());
            }
            return $this->redirect($this->router->generate('admin_account_deposit',['accountNumber'=>$account->getAccountNumber()]));
        }
        $view = $this->template->load('BankBundle:Account:account_deposit');
        $view->pageTitle = 'Deposit Cash';
        $view->account = $account;
        $this->template->setTitle('Admin')
             ->bind('page_header',$this->template->getTitle())
             ->bind('content',$view);
        return $this->template;
    }       

    /*
     * @ParamConverter("account", class="BankBundle:Account", options={"mapping": {"accountNumber" = "accountNumber"}})
     */
    public function withdrawAction(Request $request, Account $account) 
    {
        if('POST' === $request->getMethod()){
            try{
                $transaction = new DebitTransaction();
                $transaction->setDateCreated(new \DateTime('now'));
                $transaction->setDescription($request->get('description'));
                $transaction->setAmount($request->get('amount'));
                $transaction->setAccount($account);

                $this->entityManager->persist($transaction);
                $this->entityManager->flush();
            }catch(InsufficientFundException $e){
                $this->flash->setInfo($e->getMessage());
                return $this->redirect($this->router->generate('admin_account_withdraw',['accountNumber'=>$account->getAccountNumber()]));
            }
            return $this->redirect($this->router->generate('admin_account_withdraw',['accountNumber'=>$account->getAccountNumber()]));
        }        
        $view = $this->template->load('BankBundle:Account:account_deposit');
        $view->pageTitle = 'Withdrawal Form';
        $view->account = $account;
        $this->template->setTitle('Admin')
             ->bind('page_header',$this->template->getTitle())
             ->bind('content',$view);
        return $this->template;
    }


    public function deleteAction(Request $request)
    {

    }

    private function getTransactionType($type)
    {
        if($type == 'credit'){
            return new CreditTransaction;
        }
        return new DebitTransaction;
    }    
   
}
