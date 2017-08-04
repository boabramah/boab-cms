<?php

namespace Invetico\BankBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Invetico\BoabCmsBundle\Controller\AdminController;
use Invetico\BoabCmsBundle\Controller\AccountPanelInterface;
use Invetico\BoabCmsBundle\Controller\InitializableControllerInterface;
use Invetico\BankBundle\Repository\AccountRepositoryInterface;
use Invetico\BankBundle\Repository\TransactionRepositoryInterface;
use Invetico\BankBundle\Entity\CreditTransaction;
use Invetico\BankBundle\Entity\DebitTransaction;
use Invetico\UserBundle\Repository\UserRepositoryInterface;
use Invetico\BankBundle\Exception\InsufficientFundException;


class ActivityController extends AdminController implements InitializableControllerInterface
{
    private $accountRepository;
    private $transactionRepository;
    private $userRepository;
    
    public function __Construct
    (
        AccountRepositoryInterface $accountRepository, 
        TransactionRepositoryInterface $transactionRepository, 
        UserRepositoryInterface $userRepository
    ) 
    {
        $this->accountRepository = $accountRepository;
        $this->transactionRepository = $transactionRepository;
        $this->userRepository = $userRepository;
    }


    public function initialize()
    {
        $this->template->setTheme('jayle');
    }


    public function indexAction(Request $request) 
    {
        
        if('POST' === $request->getMethod()){
            
            $accountNumber = $request->get('account_number');
            $account = $this->accountRepository->findByAccountNumber($accountNumber);

            try{
                $transaction = $this->getTransactionType($request->get('transaction_type'));
                $transaction->setDateCreated(new \DateTime('now'));
                $transaction->setDescription($request->get('description'));
                $transaction->setAmount($request->get('amount'));
                $transaction->setAccount($account);

                $this->entityManager->persist($transaction);
                $this->entityManager->flush();
            }catch(InsufficientFundException $e){
                $this->flash->setInfo($e->getMessage());
                return $this->redirect($this->router->generate('activity_index'));
            }
            return $this->redirect($this->router->generate('activity_index'));
        }

        $customer = $this->userRepository->findUserById($this->getUserToken()->getId());
        $accounts = $this->accountRepository->findAccountByCustomer($customer);
        $view = $this->template->load('BankBundle:Account:add_activity');
        $view->accounts = $accounts;
        $this->template->setTitle('Activity')
             ->bind('content',$view)
             ->bind('page_header',$this->template->getTitle());
        return $this->template; 
    }


    private function getTransactionType($type)
    {
        if($type == 'credit'){
            return new CreditTransaction();
        }
        return new DebitTransaction();
    }

}
