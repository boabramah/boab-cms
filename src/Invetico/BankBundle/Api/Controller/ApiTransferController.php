<?php

namespace Invetico\BankBundle\Api\Controller;

use Symfony\Component\HttpFoundation\Request;
use Invetico\BankBundle\Repository\AccountRepositoryInterface;
use Invetico\BankBundle\Repository\TransactionRepositoryInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Invetico\UserBundle\Repository\UserRepositoryInterface;
use Invetico\BoabCmsBundle\Controller\BaseController;
use Invetico\BankBundle\Entity\LocalTransfer;
use Invetico\BankBundle\Entity\DomesticTransfer;
use Invetico\BankBundle\Repository\TransferRepositoryInterface;
use Invetico\ApiBundle\Exception\ApiException;
use Invetico\BankBundle\Entity\TransferInterface;
use Symfony\Component\Serializer\SerializerInterface;


Class ApiTransferController extends BaseController
{
    private $accountRepository;
    private $transferRepository;
    private $serializer;

    public function __Construct(TransferRepositoryInterface $transferRepository, AccountRepositoryInterface $accountRepository, SerializerInterface $serializer) 
    {
        $this->transferRepository = $transferRepository;        
        $this->accountRepository = $accountRepository;     
        $this->serializer = $serializer;     
    }

    /*
     * GET /api/transfers
     */
    public function listTransferAction(Request $request, $userId, $format) 
    {
        $transfers = $this->transferRepository->findTransfersByCustomerId($userId);
        if(!$transfers){
            throw new ApiException(404, 'No transfers found');
        }        
        return $this->serializer->serialize($transfers, $format);
    }

    /*
     * GET /api/accounts/{accountNumber}/transfers
     */
    public function listAccountTransfersAction(Request $request, $accountNumber, $format) 
    {
        $transfers = $this->transferRepository->findTransfersByAccountNumber($accountNumber);
        
        return $this->serializer->serialize($transfers, $format);
    }     

    /*
     * GET /api/transfers/{transferId}
     */
    public function showTransferAction(Request $request, $transferId, $format)
    {
        $transfer = $this->transferRepository->findTransferById($transferId);
        if(!$transfer instanceof TransferInterface){
            throw new ApiException(404, 'Transfer not found');
        }
        return $this->serializer->serialize($transfer, $format, ['groups'=>['detail']]);
    }

    /**
     * DELETE /api/transfers/{transferId}
     */
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
