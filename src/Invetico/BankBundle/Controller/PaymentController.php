<?php

namespace Invetico\BankBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Invetico\BoabCmsBundle\Controller\AdminController;
use Invetico\BoabCmsBundle\Controller\AccountPanelInterface;
use Invetico\BoabCmsBundle\Controller\InitializableControllerInterface;
use Invetico\BankBundle\Repository\AccountRepositoryInterface;
use Invetico\BankBundle\Entity\CreditTransaction;
use Invetico\BankBundle\Entity\DebitTransaction;


class PaymentController extends AdminController implements InitializableControllerInterface
{
    private $accountRepository;
    
    public function __Construct(AccountRepositoryInterface $accountRepository) 
    {
        $this->accountRepository = $accountRepository;
    }


    public function initialize()
    {
        $this->template->setTheme('jayle');
    }


    public function indexAction(Request $request) 
    {
        $this->template->setTitle('Pay Bills')
             ->bind('page_header',$this->template->getTitle());
        return $this->template; 
    }


    public function depositAction(Request $request, $accountNumber)
    {
        if('POST' === $request->getMethod()){
            $transaction = new CreditTransaction();
            $transaction->setDateCreated(new \DateTime('now'));
            $transaction->setDescription('Cash Deposit by Ernest Boabramah');
            $transaction->setCreditAmount(230);

            $account = $this->accountRepository->findByAccountNumber($accountNumber);
            $account->addTransaction($transaction);
        }


        $view = $this->template->load('BankBundle:Account:deposit');

        $this->template->setTitle('Deposit Cash')
             ->bind('page_header',$this->template->getTitle())
             ->bind('content',$view);
        return $this->template;        

    }

    
    public function withdrawAction(Request $request)
    {

    }

}
