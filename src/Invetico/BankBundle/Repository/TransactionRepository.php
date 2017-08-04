<?php
namespace Invetico\BankBundle\Repository;

use Invetico\BoabCmsBundle\Repository\BaseRepository;
use Doctrine\DBAL\Types\Type;

class TransactionRepository extends BaseRepository implements TransactionRepositoryInterface
{

    public function findAccountsTransactions($accountId)
    {
        return $this->getTransactionQuery()
                ->where('a.id = :accountId')
                ->setParameter('accountId', $accountId)
                ->orderBy('t.dateCreated','DESC')
                ->getQuery()->getResult();
    }

    public function findTransactionById($transId)
    {
        return $this->getTransactionQuery()
                ->where('t.id = :transId')
                ->setParameter('transId', $transId)
                ->getQuery()->getOneOrNullResult();
    }

    public function findTransactionsByCustomerId($customerId)    
    {
        return $this->getTransactionQuery()
                ->addSelect('u')
                ->leftJoin('a.customer','u')
                ->where('u.id = :customerId')
                ->setParameter('customerId', $customerId)
                ->orderBy('t.dateCreated','DESC')
                ->getQuery()->getResult();        
    }


    public function findTransactionsByAccountNumber($accountNumber)
    {
        $qb = $this->getTransactionQuery();
        $qb->where('a.accountNumber = :accountNumber')
           ->setParameter('accountNumber',$accountNumber)
           ->orderBy('t.dateCreated','DESC');
        return $qb->getQuery()->getResult();
    }    

    public function findAccountTransactions($account)
    {
        $qb = $this->getTransactionQuery();
        $qb->where('a.accountNumber = :accountNumber')
           ->setParameter('accountNumber',$account->getAccountNumber())
           ->orderBy('t.dateCreated','DESC');
        return $qb->getQuery()->getResult();
    }


    public function findTransactionsByDate($accountId, $startDate, $endDate, $limit='')
    {
        $qb = $this->getTransactionQuery();
        $qb->where('a.id = :accountId')
           ->andWhere('t.dateCreated BETWEEN :startDate AND :endDate')
           ->setParameter('startDate', new \DateTime($startDate), Type::DATETIME)
           ->setParameter('endDate', $this->add24h(new \DateTime($endDate)), Type::DATETIME)
           ->setParameter('accountId', $accountId)
           ->orderBy('t.dateCreated','DESC');  
        if($limit){
            $qb->setFirstResult(0)
            ->setMaxResults($limit);
            return $qb->getQuery()->getResult();          
        }
      return $qb->getQuery()->getResult();        

    }         


    public function getTransactionQuery()
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->addSelect('t','a')
           ->from('Invetico\BankBundle\Entity\Transaction', 't')
           ->leftJoin('t.account','a');
        return $qb;
    }    

}