<?php
namespace Invetico\BankBundle\Repository;

use Invetico\BoabCmsBundle\Repository\BaseRepository;
use Doctrine\DBAL\Types\Type;

class TransferRepository extends BaseRepository implements TransferRepositoryInterface
{
    
    public function findAllTransfers()
    {
        $qb = $this->getTransferQuery();
        $qb->orderBy('t.dateCreated','DESC');

        return $qb->getQuery()->getResult();
    }


    public function findTransferById($transferId)   
    {
        $qb = $this->getTransferQuery();
        $qb->where('t.id = :id')
           ->setParameter('id', $transferId);
        //return $qb->getQuery()->getArrayResult();      
        return $qb->getQuery()->getOneOrNullResult();         
    }

    public function findTransfersByCustomerId($customerId)
    {
    	$qb = $this->getTransferQuery()
                   ->leftJoin('t.customer', 'c')
                   ->where('c.id = :customerId')
                   ->orderBy('t.dateCreated','DESC')
                   ->setParameter('customerId',$customerId);

    	return $qb->getQuery()->getResult();
    }

    public function findTransfersByAccountNumber($accountNumber)
    {
        return $this->getTransferQuery()
            ->leftJoin('t.customer', 'c')
            //->where("SUBSTRING_INDEX(t.fromAccount, '-', :offset) = :accountNumber")
            //SUBSTRING(r.email, LOCATE('@', r.email)+1)
            ->where("SUBSTRING(t.fromAccount, LOCATE('-', t.fromAccount)+1) = :accountNumber")
            ->orderBy('t.dateCreated','DESC')
            ->setParameter('accountNumber',$accountNumber)
            //->setParameter('offset','-1')
            ->getQuery()->getResult();
       
    }

    //Dashes are not allowed as they could be part of an SQL injection attack. Either get rid of the dash, or break out the negative number into a parameter.

    public function findTotalPendingTransfersByCustomerId($customerId)
    {
        $qb = $this->_em->createQueryBuilder();
        return $qb->select('SUM(t.amount) as total_balance')
            ->from('Invetico\BankBundle\Entity\Transfer', 't')
            ->leftJoin('t.customer','c')
            ->where('t.authStatus = :auth_status')
            ->andWhere('t.status = :status')
            ->andWhere('c.id = :customerId')
            ->setParameter('auth_status', 'passed')
            ->setParameter('status','pending')
            ->setParameter('customerId',$customerId)
            ->getQuery()
            ->getSingleScalarResult();         
    }


    public function findLatestTransfer($customerId, $limit)
    {
        $qb = $this->getTransferQuery()
            ->leftJoin('t.customer','c')
            ->where('t.status = :status')
            ->andWhere('t.authStatus = :auth_status')
            ->andWhere('c.id = :customerId')
            ->orderBy('t.dateCreated', 'DESC')
            ->setParameter('auth_status', 'passed')
            ->setParameter('status','pending')
            ->setParameter('customerId',$customerId)
            ->getQuery()
            ->setFirstResult(0)
            ->setMaxResults($limit);

        return $qb->getResult();
    }

    public function findTransferByDate($customerId, $startDate=null, $endDate=null, $limit='')
    {
        $qb = $this->getTransferQuery()
            ->leftJoin('t.customer','c')
            ->where('c.id = :customerId')
            ->andWhere('t.dateCreated BETWEEN :startDate AND :endDate')
            ->setParameter('startDate', new \DateTime($startDate), Type::DATETIME)
            ->setParameter('endDate', $this->add24h(new \DateTime($endDate)), Type::DATETIME)
            ->setParameter('customerId', $customerId)
            ->orderBy('t.dateCreated','DESC');  
        if($limit){
            $qb->setFirstResult(0)
            ->setMaxResults($limit);
            return $qb->getQuery()->getResult();          
        }
      return $qb->getQuery()->getResult();
    }  
          

    public function getTransferQuery()
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('t')
           ->from('Invetico\BankBundle\Entity\Transfer', 't');
        return $qb;
    }    

}