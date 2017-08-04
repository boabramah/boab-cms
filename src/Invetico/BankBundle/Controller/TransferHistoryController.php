<?php

namespace Invetico\BankBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Invetico\BoabCmsBundle\Controller\InitializableControllerInterface;
use Invetico\BankBundle\Repository\AccountRepositoryInterface;
use Invetico\BankBundle\Repository\TransactionRepositoryInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Invetico\UserBundle\Repository\UserRepositoryInterface;
use Utils\AjaxJsonResponse;
use Invetico\BoabCmsBundle\Controller\AdminController;
use Invetico\BankBundle\Entity\LocalTransfer;
use Invetico\BankBundle\Entity\DomesticTransfer;
use Invetico\BankBundle\Repository\TransferRepositoryInterface;
use Invetico\ApiBundle\Normalizer\SuccessResponseNormalizer;
use Symfony\Component\HttpKernel\Exception\HttpException;


Class TransferHistoryController extends AdminController implements InitializableControllerInterface
{
    private $accountRepository;
    private $transactionRepository;
    private $userRepository;
    private $transferRepository;

    public function __Construct
    (
        AccountRepositoryInterface $accountRepository,
        TransactionRepositoryInterface $transactionRepository, 
        UserRepositoryInterface $userRepository,
        TransferRepositoryInterface $transferRepository
    ) 
    {
        $this->accountRepository = $accountRepository;
        $this->transactionRepository = $transactionRepository;
        $this->userRepository = $userRepository;
        $this->transferRepository = $transferRepository;     
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


    public function historyAction(Request $request)
    {
        $view = $this->template->load('BankBundle:Transfer:history');
        $view->collection = $this->getTransferCollection($request);
        $view->start_date = $request->get('start_date');
        $view->end_date = $request->get('end_date');
        $view->generateDeleteUrl = function($transfer){
            return $this->router->generate('transfer_delete',['transferId'=>$transfer->getId()]);
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


    public function deleteTransferAction(Request $request, $transferId)
    {
        $transfer = $this->transferRepository->findTransferById($transferId);

        if(!$transfer) {
            throw new HttpException(403,'Bad request! Transfer does not exist');
        }

        //$event = new ContentDeletedEvent($content);
        //$this->eventDispatcher->dispatch('content.delete', $event);

        $message = sprintf('Transfer with reference number <strong>#%s</strong> deleted successfully', $transfer->getReferenceNumber());
        
        $this->entityManager->remove($transfer);
        $this->entityManager->flush();

        $normalizer = new SuccessResponseNormalizer([]);
        $normalizer->setMessage($message);
        return $normalizer;        
    }
   
}
