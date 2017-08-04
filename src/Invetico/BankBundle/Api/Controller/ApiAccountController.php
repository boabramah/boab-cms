<?php

namespace Invetico\BankBundle\Api\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Invetico\BoabCmsBundle\Controller\BaseController;
use Invetico\BankBundle\Repository\AccountRepositoryInterface;
use Invetico\BankBundle\Model\AccountTypeManagerInterface;
use Invetico\BankBundle\Event\AccountCreatedEvent;
use Invetico\BankBundle\Entity\Account;
use Invetico\UserBundle\Repository\UserRepositoryInterface;
use Invetico\ApiBundle\Exception\ApiException;
use Invetico\BankBundle\Entity\AccountInterface;
use Symfony\Component\Serializer\SerializerInterface;

Class ApiAccountController extends BaseController
{
    private $accountRepository;
    private $userRepository;
    private $serializer;

    public function __Construct
    (
        AccountRepositoryInterface $accountRepository, 
        SerializerInterface $serializer,        
        UserRepositoryInterface $userRepository
    ) 
    {
        $this->accountRepository = $accountRepository;
        $this->userRepository = $userRepository;
        $this->serializer = $serializer;        
    }

    /*
     * GET /api/accounts
     */
    public function listAccountsAction(Request $request, $userId, $format) 
    {
        $accounts = $this->accountRepository->findAccountsByCustomerId($userId);

        return $this->serializer->serialize($accounts,$format);
    }

    /*
     * GET /api/accounts/{accountNumber}
     */
    public function showAccountAction(Request $request, $accountNumber, $format) 
    {
        $account = $this->accountRepository->findByAccountNumber($accountNumber);
        if(!$account instanceof AccountInterface){
            throw new ApiException(404, sprintf('Account number #%s not found', $accountNumber));
        }
        return $this->serializer->serialize($account, $format);
    }    

    /*
     * POST /api/accounts
     */
    public function addAccountAction(Request $request, $userId) 
    {
        $user = $this->entityManager->getReference('UserBundle:User', $userId);
        
        $accountType = $request->get('accountType');
        $account = $this->accountTypeManager->getAccountType($accountType);
        $account->setAccountStatus('OPEN');
        $account->setBalance(0);
        $account->setDateCreated(new \DateTime('Now'));
        $account->setCustomer($user);

        $this->entityManager->persist($account);
        $this->entityManager->flush();

        $this->eventDispatcher->dispatch('account.create', new AccountCreatedEvent($account));              

        return $account;
    }                 
   
}


