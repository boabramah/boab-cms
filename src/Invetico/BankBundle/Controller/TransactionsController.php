<?php

namespace Invetico\BankBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Invetico\BoabCmsBundle\Controller\BaseController;
use Invetico\BoabCmsBundle\Controller\InitializableControllerInterface;
use Invetico\BankBundle\Repository\TransactionRepositoryInterface;
use Invetico\BankBundle\Entity\Account;
use Symfony\Component\Security\Core\User\UserInterface;
use Invetico\UserBundle\Repository\UserRepositoryInterface;
use Utils\AjaxJsonResponse;
use Invetico\BoabCmsBundle\Controller\AdminController;


Class TransactionsController extends AdminController implements InitializableControllerInterface
{
    private $userIdentity;
    private $transactionRepository;
    private $userRepository;

    public function __Construct(TransactionRepositoryInterface $transactionRepository, UserRepositoryInterface $userRepository) 
    {
        $this->transactionRepository = $transactionRepository;
        $this->userRepository = $userRepository;    
    }

    public function initialize()
    {      
        $this->template->setTheme('jayle');
    }

    public function indexAction(Request $request) 
    {
        $transactions = $this->transactionRepository->findAllTransactions();

        $view = $this->template->load('BankBundle:Account:transactions');
        $view->transactions = $transactions;
        $this->template->setTitle('Transactions')
             ->bind('page_header',$this->template->getTitle())
             ->bind('content',$view);
        return $this->template;
    }

    /*
     * @ParamConverter("account", class="BankBundle:Account", options={"mapping": {"accountNumber" = "accountNumber"}})
     */
    public function transactionAction(Request $request, Account $account)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $view = $this->template->load('BankBundle:Account:transactions');
        $view->transactions = $this->getAccountTransactions($request, $account, $startDate, $endDate);
        $view->start_date = $startDate;
        $view->end_date = $endDate;
        $view->account = $account;
        $this->template->setTitle('Transactions')
             ->bind('page_header',$this->template->getTitle())
             ->bind('content',$view);
        return $this->template;        
    }

    private function getAccountTransactions($request, $account, $startDate, $endDate)
    {
        if('POST' == $request->getMethod()){
            return $this->transactionRepository->findTransactionsByDate($account->getId(), $startDate, $endDate);
        } 
        return $transactions = $this->transactionRepository->findAccountTransactions($account);
    }    
   
}
