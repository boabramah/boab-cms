<?php

namespace Invetico\BankBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Invetico\BoabCmsBundle\Controller\InitializableControllerInterface;
use Invetico\BankBundle\Repository\AccountRepositoryInterface;
use Invetico\BankBundle\Repository\TransferRepositoryInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Invetico\UserBundle\Repository\UserRepositoryInterface;
use Utils\AjaxJsonResponse;
use Invetico\BoabCmsBundle\Controller\AdminController;
use Invetico\BankBundle\Entity\LocalTransfer;
use Invetico\BankBundle\Entity\Transfer;
use Invetico\BankBundle\Entity\DomesticTransfer;
use Invetico\BankBundle\Event\TransferCreatedEvent;
use Invetico\BankBundle\Event\TransferAuthorizeEvent;
use Invetico\BankBundle\Entity\CreditTransaction;
use Invetico\BankBundle\Entity\DebitTransaction;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Invetico\ApiBundle\Normalizer\SuccessResponseNormalizer;
use Invetico\BankBundle\Exception\InsufficientFundException;


Class AdminTransferController extends AdminController implements InitializableControllerInterface
{
    private $accountRepository;
    private $transferRepository;
    private $userRepository;

    public function __Construct
    (
        AccountRepositoryInterface $accountRepository,
        TransferRepositoryInterface $transferRepository, 
        UserRepositoryInterface $userRepository
    ) 
    {
        $this->accountRepository = $accountRepository;
        $this->transferRepository = $transferRepository;
        $this->userRepository = $userRepository;   
    }

    public function initialize()
    {      
        $this->template->setTheme('jayle');
    }

    public function indexAction(Request $request) 
    {
        $view = $this->template->load('BankBundle:Transfer:admin_history');
        $view->collection = $this->transferRepository->findAllTransfers();
        $view->start_date = $request->get('start_date');
        $view->end_date = $request->get('end_date');
        $view->generateApproveUrl = function($transfer){
            return $this->router->generate('admin_transfers_approve',['reference'=>$transfer->getReferenceNumber()]);
        };
        $this->template->setTitle('Fund Transfers')
             ->bind('page_header',$this->template->getTitle())
             ->bind('content',$view);
        return $this->template; 
    } 

    private function getTransferCollection($request)
    {
        if('POST' == $request->getMethod()){
            $startDate = $request->get('start_date');
            $endDate = $request->get('end_date');
            return $this->transferRepository->findTransferByDate($this->getUserToken()->getId(), $startDate, $endDate);
        } 
        return $this->transferRepository->findTransfersByCustomerId($this->getUserToken()->getId());
    }


    public function approveAction(Request $request, $reference)
    {
        $transfer = $this->transferRepository->findOneBy(['referenceNumber'=>$reference]);
        if($transfer->isCompleted()){
            throw new HttpException(409, 'Transfer already completed');
        }
        switch ($transfer->getTransferType()) {
            case 'local':
                $fromNumber = $this->getAccountNumber($transfer->getFromAccount());
                $toNumber = $this->getAccountNumber($transfer->getToAccount());

                $fromAccount = $this->accountRepository->findByAccountNumber($fromNumber);
                $toAccount = $this->accountRepository->findByAccountNumber($toNumber);
                $transfer->setStatus(Transfer::STATUS_COMPLETED);
                $this->createLocalTransaction($transfer, $fromAccount, $toAccount);
                $this->entityManager->persist($transfer);
                $this->entityManager->flush();

                break;

            case 'domestic':
                $accountNumber = $this->getAccountNumber($transfer->getFromAccount());
                $fromAccount = $this->accountRepository->findByAccountNumber($accountNumber);
                try{
                    $transaction = new DebitTransaction();
                    $transaction->setDateCreated(new \DateTime);
                    $transaction->setAmount($transfer->getAmount());
                    $message = sprintf('Fund transfer of [currency amount=%s] to account %s, Reference #%s', $transfer->getAmount(), $transfer->getToAccount(), $transfer->getReferenceNumber());
                    $transaction->setDescription($message);        
                    $transaction->setAccount($fromAccount);

                    $transfer->setStatus(Transfer::STATUS_COMPLETED);
                    $this->entityManager->persist($transfer);                
                    $this->entityManager->persist($transaction); 
                    $this->entityManager->flush();
                }catch(InsufficientFundException $e){
                    throw new HttpException(409, $e->getMessage());
                }

                break;                
            
            default:
                break;
        }

        $normalizer = new SuccessResponseNormalizer([]);
        $normalizer->setMessage('Transfer approved successfully');
        return $normalizer;        
    }


    private function getAccountNumber($desc)
    {
        $number = explode('-', $desc)[1];
        return trim($number);
    }


    private function createLocalTransaction($transfer, $fromAccount, $toAccount)
    {
        $transaction = new DebitTransaction();
        $transaction->setDateCreated(new \DateTime('now'));
        $transaction->setAmount($transfer->getAmount());
        $message = sprintf('Fund transfer of [currency amount=%s] to account %s, Reference #%s', $transfer->getAmount(), $toAccount->getAccountNumber(), $transfer->getReferenceNumber());
        $transaction->setDescription($message);        
        $transaction->setAccount($fromAccount);
        $this->entityManager->persist($transaction);

        $creditTransaction = new CreditTransaction();
        $creditTransaction->setDateCreated(new \DateTime('now'));
        $creditTransaction->setAmount($transfer->getAmount());
        $toMessage = sprintf('Funds recieved [currency amount=%s] from Account %s, Reference #%s', $transfer->getAmount(), $fromAccount->getAccountNumber(), $transfer->getReferenceNumber());
        $creditTransaction->setDescription($toMessage);        
        $creditTransaction->setAccount($toAccount);
        $this->entityManager->persist($creditTransaction);        
    }    

}
