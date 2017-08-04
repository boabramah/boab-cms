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
use Invetico\BankBundle\Exception\InvalidTransferAuthorizationException;


Class FundsTransferController extends AdminController implements InitializableControllerInterface
{
    private $accountRepository;
    private $userIdentity;
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
        $this->userIdentity = $this->securityContext->getIdentity();
    }

    public function indexAction(Request $request) 
    {
        $view = $this->template->load('BankBundle:Account:funds_transfer_type');
        $this->template->setTitle('Funds Transfer')
             ->bind('page_header',$this->template->getTitle())
             ->bind('content',$view);
        return $this->template;
    } 


    public function createAction(Request $request, $transferType='')   
    {
        $customer = $this->userRepository->findUserById($this->getUserToken()->getId());
        $accounts = $this->accountRepository->findAccountByCustomer($customer);

        $view = $this->template->load(sprintf('BankBundle:Transfer:funds_transfer_%s',$transferType));
        $view->accounts = $accounts;
        $this->template->setTitle('Funds Transfer')
             ->bind('page_header',$this->template->getTitle())
             ->bind('content',$view);
        return $this->template;
    }


    public function confirmAction(Request $request, $transferType='')
    {
        $customer = $this->userRepository->findUserById($this->getUserToken()->getId());
        $accounts = $this->accountRepository->findAccountByCustomer($customer);
        $view = $this->template->load(sprintf('BankBundle:Transfer:transfer_%s_confirm',$transferType));
        $view->accounts = $accounts;

        if('local' == $transferType){
            $this->populateLocalTransferView($view, $request);
        }else{
            $this->populateDomesticTransferView($view, $request);
        }

        $this->template->setTitle('Funds Transfer')
             ->bind('page_header',$this->template->getTitle())
             ->bind('content',$view);
        return $this->template;
    }


    public function saveAction(Request $request, $transferType='')
    {
        $fromAccount = $this->accountRepository->findByAccountNumber($request->get('from_account'));
        $userReference = $this->entityManager->getReference('Invetico\UserBundle\Entity\User',$this->getUserToken()->getId());
        switch ($transferType) {

            case 'local':
                $toAccount = $this->accountRepository->findByAccountNumber($request->get('to_account'));
                $transfer = $this->createLocalTransferEntity($request);
                $transfer->setFromAccount(sprintf('%s-%s',$fromAccount->getAccountName(),$fromAccount->getAccountNumber()));
                $transfer->setToAccount(sprintf('%s-%s',$toAccount->getAccountName(),$toAccount->getAccountNumber()));            
                $transfer->setCustomer($userReference);
                $transfer->setAuthStatus(Transfer::AUTH_STATUS_PASSED);
                $event = new TransferCreatedEvent($transfer);
                $this->eventDispatcher->dispatch('transfer.create', $event);
                $this->entityManager->persist($event->getTransfer());
                if($transfer->isToday()){
                    $this->createLocalTransaction($request, $transfer, $fromAccount, $toAccount);
                }
                $this->flash->setSuccess('Transfer processed succesfully');
                $this->entityManager->flush();

                break;

            case 'domestic':
                $transfer = $this->createDomesticTransferEntity($request);
                $transfer->setFromAccount(sprintf('%s-%s',$fromAccount->getAccountName(),$fromAccount->getAccountNumber()));
                $transfer->setToAccount(sprintf('%s,%s',$transfer->getReceiverName(),$transfer->getReceiverBankName()));            
                $transfer->setAuthStatus(Transfer::AUTH_STATUS_FAILED);
                $transfer->setCustomer($userReference);
                $event = new TransferCreatedEvent($transfer);
                $this->eventDispatcher->dispatch('transfer.create', $event);
                $this->entityManager->persist($event->getTransfer());
                //if($transfer->isToday()){
                    //$this->createDomesticTransaction($request, $transfer, $fromAccount);                                 
                //}
                $this->entityManager->flush();
                return $this->redirect($this->router->generate('transfers_authorize',['reference'=>$transfer->getReferenceNumber()]));
                break;

            default:
                throw new HttpException(403,sprintf("Error Processing Request. Transfer Type %s is not recognize", $transferType));
                break;
        }

        return $this->redirect($this->router->generate('transfers_create',['transferType'=>$transferType]));
    }

    private function createDomesticTransaction($request, $entity, $fromAccount)
    {
        $transaction = new DebitTransaction();
        $transaction->setDateCreated($entity->getDateCreated());
        $transaction->setAmount($entity->getAmount());
        $message = sprintf('Fund transfer of [currency amount=%s] to account %s, Reference #%s', $entity->getAmount(), $entity->getToAccount(), $entity->getReferenceNumber());
        $transaction->setDescription($message);        
        $transaction->setAccount($fromAccount);
        $this->entityManager->persist($transaction);
    }    

    private function populateDomesticTransferView($view, $request)
    {
        $fromAccount = $this->accountRepository->findByAccountNumber($request->get('from_account'));
        $view->fromAccount = $fromAccount;
        $view->transferAmount = $request->get('transfer_amount');
        $view->transferDate = $request->get('transfer_date');
        $view->isRepeatable = ($request->get('is_repeatable')) ? 'Yes':'No';
        $view->isRepeatableValue = ($request->get('is_repeatable')) ? 1 : 0;
        $view->transferFrequency = $request->get('transfer_frequency');
        $view->receiverBankName = $request->get('receiver_bank_name'); 
        $view->receiverAccountName = $request->get('receiver_account_name'); 
        $view->routingNumber = $request->get('routing_number'); 
        $view->receiverName = $request->get('receiver_name'); 
        $view->description = $request->get('description'); 
    }

    private function createDomesticTransferEntity(Request $request)
    {
        $entity = new DomesticTransfer();
        $entity->setDateCreated(new \DateTime);
        $entity->setAmount($request->get('transfer_amount'));
        
        $status = $this->isToday($request->get('transfer_date')) ? 'completed':'pending';

        $entity->setStatus(Transfer::STATUS_PENDING);
        $entity->setProcessDate(new \DateTime($request->get('transfer_date')));
        $entity->setIsRepeatable($request->get('is_repeatable') ? 1 : 0);
        $entity->setTransferFrequency($request->get('transfer_frequency'));
        $entity->setReceiverBankName($request->get('receiver_bank_name'));
        $entity->setReceiverName($request->get('receiver_name'));
        $entity->setReceiverAccountNumber($request->get('receiver_account_name'));
        $entity->setRoutingNumber($request->get('routing_number'));
        $entity->setDescription($request->get('description'));

        return $entity;        
    }    

    private function createLocalTransaction($request, $transfer, $fromAccount, $toAccount)
    {
        $transaction = new DebitTransaction();
        $transaction->setDateCreated($transfer->getDateCreated());
        $transaction->setAmount($transfer->getAmount());
        $message = sprintf('Fund transfer of [currency amount=%s] to account %s, Reference #%s', $transfer->getAmount(), $toAccount->getAccountNumber(), $transfer->getReferenceNumber());
        $transaction->setDescription($message);        
        $transaction->setAccount($fromAccount);
        $this->entityManager->persist($transaction);

        $creditTransaction = new CreditTransaction();
        $creditTransaction->setDateCreated($transfer->getDateCreated());
        $creditTransaction->setAmount($transfer->getAmount());
        $toMessage = sprintf('Funds recieved [currency amount=%s] from Account %s, Reference #%s', $transfer->getAmount(), $fromAccount->getAccountNumber(), $transfer->getReferenceNumber());
        $creditTransaction->setDescription($toMessage);        
        $creditTransaction->setAccount($toAccount);
        $this->entityManager->persist($creditTransaction);        
    }

    private function createLocalTransferEntity(Request $request)
    {
        $entity = new LocalTransfer();
        $entity->setDateCreated(new \DateTime);
        $entity->setAmount($request->get('transfer_amount'));
        
        $status = $this->isToday($request->get('transfer_date')) ? 'completed':'pending';
        
        $entity->setStatus($status);
        $entity->setProcessDate(new \DateTime($request->get('transfer_date')));
        $entity->setIsRepeatable($request->get('is_repeatable') ? 1 : 0);
        $entity->setTransferFrequency($request->get('transfer_frequency'));
        $entity->setDescription($request->get('description'));

        return $entity;        
    }

    private function isToday($date)
    {
       return date('Ymd', strtotime($date)) === date('Ymd');
    }


    private function populateLocalTransferView($view, $request)
    {
        $fromAccount = $this->accountRepository->findByAccountNumber($request->get('from_account'));
        $toAccount = $this->accountRepository->findByAccountNumber($request->get('to_account'));
        $view->fromAccount = $fromAccount;
        $view->toAccount = $toAccount;
        $view->transferAmount = $request->get('transfer_amount');
        $view->transferDate = $request->get('transfer_date');
        $view->isRepeatable = ($request->get('is_repeatable')) ? 'Yes':'No';
        $view->isRepeatableValue = ($request->get('is_repeatable')) ? 1 : 0;
        $view->transferFrequency = $request->get('transfer_frequency');
        $view->description = $request->get('description');    
    }


    public function authorizeAction(Request $request, $reference) 
    {

        $transfer = $this->transferRepository->findOneBy(['referenceNumber'=>$reference]);
        if(!$transfer){
            throw new HttpException(403, sprintf("Error Processing Request: Invalid reference number <b>%s</b>", $reference));  
        }
              

        if('POST' == $request->getMethod()){
            $code = $request->get('auth_code');
            try{
                if($code != $transfer->getAuthorizationCode()){
                    throw new InvalidTransferAuthorizationException('Invalid Transfer Authorization Code');
                }
                if($transfer->authExpired()){
                    throw new InvalidTransferAuthorizationException("The Transfer Authorization Code has expired");                
                }
            }catch(InvalidTransferAuthorizationException $e){
                $this->flash->setInfo($e->getMessage());
                return $this->redirect($this->router->generate('transfers_authorize',['reference'=>$reference]));
            }

            $transfer->setAuthStatus(Transfer::AUTH_STATUS_PASSED);
            $this->entityManager->persist($transfer);
            $this->entityManager->flush();

            $this->flash->setSuccess('Transfer validated succesfully will be process on the due date');
            return $this->redirect($this->router->generate('account_list'));
        }

        $customer = $this->userRepository->findUserById($this->getUserToken()->getId());
        
        $event = new TransferAuthorizeEvent($transfer);
        $event->setCustomer($customer);
        $this->eventDispatcher->dispatch('transfer.authorize', $event);
        
        $view = $this->template->load('BankBundle:Transfer:transfer_authorization');
        $view->customer = $customer;
        $this->template->setTitle('Transfer Authorization Code')
             ->bind('page_header',$this->template->getTitle())
             ->bind('content',$view);
        return $this->template;
    }

    private function getTransactionType($type)
    {
        if($type == 'credit'){
            return new CreditTransaction;
        }
        return new DebitTransaction;
    }

}
