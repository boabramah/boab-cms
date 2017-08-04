<?php

namespace Invetico\BankBundle\Api\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Invetico\BoabCmsBundle\Controller\BaseController;
use Invetico\BankBundle\Repository\TransactionRepositoryInterface;
use Invetico\BankBundle\Entity\Account;
use Symfony\Component\Serializer\SerializerInterface;
use Invetico\ApiBundle\Exception\ApiException;
use Invetico\BankBundle\Entity\TransactionInterface;
use Invetico\BankBundle\Repository\AccountRepositoryInterface;


Class ApiTransactionController extends BaseController
{
    private $transactionRepository;
    private $accountRepository;
    private $serializer;


    public function __Construct(TransactionRepositoryInterface $transactionRepository, AccountRepositoryInterface $accountRepository, SerializerInterface $serializer) 
    {
        $this->transactionRepository = $transactionRepository;
        $this->accountRepository = $accountRepository;        
        $this->serializer = $serializer;
    }

    /*
     * GET /api/transactions
     */
    public function listTransactionsAction(Request $request, $userId, $format) 
    {
        $page = $request->query->get('page');
        $size = $request->query->get('size');
        $offset = $request->query->get('offset');
        $transactions = $this->transactionRepository->findTransactionsByCustomerId($userId);
        
        return $this->serializer->serialize($transactions, $format, ['groups'=>['list']]);
    }    

    /*
     * POST /api/accounts/{accountNumber}/transactions
     */
    public function listAccountTransactionsAction(Request $request, $accountNumber, $format) 
    {
        $page = $request->query->get('page');
        $size = $request->query->get('size');
        $offset = $request->query->get('offset');
        //if($account = $this->accountRepository->)
        //die($request->get('_route'));
        $transactions = $this->transactionRepository->findTransactionsByAccountNumber($accountNumber);
        
        return $this->serializer->serialize($transactions, $format, ['groups'=>['list']]);
    }

    /*
     * GET /api/accounts/{accountNumber}/transactions/{transId}
     */
    public function showTransactionAction(Request $request, $transId, $format)
    {
        $transaction = $this->transactionRepository->findTransactionById($transId);
        if(!$transaction instanceof TransactionInterface){
            throw new ApiException(404, 'Transaction not found');
        }
        //die($request->get('_route'));
        return $this->serializer->serialize($transaction, $format);
    }

    /*
     * DELETE /api/accounts/{accountNumber}/transactions/{transId}
     */    
    public function deleteTransctionAction(Request $request, $accountId, $transId)
    {

    }
}
