<?php
namespace Invetico\BankBundle\Repository;

use Invetico\BoabCmsBundle\Repository\BaseRepository;
use Doctrine\DBAL\Types\Type;

class PaymentRepository extends BaseRepository implements PaymentRepositoryInterface
{
    private $limit = 50;
    public function findAllPayments($startDate=null, $endDate=null)
    {
        $qb = $this->getPaymentQuery();      
        if(!empty($startDate)){
            $qb->andWhere('p.dateCreated BETWEEN :startDate AND :endDate')
               ->setParameter('startDate', $startDate, Type::DATETIME)
               ->setParameter('endDate', $this->getActualEndDate($startDate, $endDate), Type::DATETIME);
        }       
      return $qb->getQuery()->getResult();
    }


    public function findTotalAmountByOfficersPayments($startDate=null, $endDate=null) 
    {
        $subQuery = $this->_em->createQueryBuilder();
        $subQuery->select('SUM(p.amount)')
                 ->from('BankBundle:Payment','p')
                 ->leftJoin('p.user','off')
                 ->where('off.id = o.id');
        $dateTime = false;

        if(!empty($startDate)){
            $dateTime = true;
            $subQuery->andWhere('p.dateCreated BETWEEN :startDate AND :endDate');
        }

        $builder = $this->_em->createQueryBuilder();
        $builder->select("o, (".$subQuery->getDql().") AS total_amount")
           ->from('UserBundle:User', 'o')
           ->where("o.account_type = 'officer'")
            ->groupBy('o');
        if($dateTime){
            $builder->setParameter('startDate', $startDate, Type::DATETIME)
                    ->setParameter('endDate', $this->getActualEndDate($startDate, $endDate), Type::DATETIME);
        }
        return $builder->getQuery()->getResult();     
    }


    public function findOfficerPayments($userId, $startDate=null, $endDate=null, $limit='')
    {
        $qb = $this->getPaymentQuery();
        $qb->where('u.id = :userId');
        
        if(!empty($startDate)){
            $qb->andWhere('p.dateCreated BETWEEN :startDate AND :endDate')
               ->setParameter('startDate', $startDate, Type::DATETIME)
               ->setParameter('endDate', $this->getActualEndDate($startDate, $endDate), Type::DATETIME);
        }
        $qb->setParameter('userId', $userId);
        $qb->orderBy('p.dateCreated','DESC');  
        if($limit){
            $qb->setFirstResult(0)
            ->setMaxResults($limit);
            return $qb->getQuery()->getResult();          
        }
      return $qb->getQuery()->getResult();
    }


    public function findOfficerCurrentPayments($userId, $startDate=null, $endDate=null)
    {
        $qb = $this->getPaymentQuery();
        $qb->where('u.id = :userId');
        
        if(!empty($startDate)){
            $qb->andWhere('p.dateCreated BETWEEN :startDate AND :endDate')
               ->setParameter('startDate', $startDate, Type::DATETIME)
               ->setParameter('endDate', $this->getActualEndDate($startDate, $endDate), Type::DATETIME);
        }
        $qb->setParameter('userId', $userId);
        $qb->orderBy('p.dateCreated','DESC');        
      return $qb->getQuery()->getResult();
    }        
    

    private function getActualEndDate($startDate, $endDate=null)
    {
        $interval = '24:00';
        if(!$endDate){
            $newDate = clone($startDate);
            return $newDate->add(new \DateInterval("P0000-00-00T$interval:00"));
        }
        return $endDate->add(new \DateInterval("P0000-00-00T$interval:00"));
    }


    public function findAllCustomerPayments($customerId)
    {
      $qb = $this->getPaymentQuery();
      $qb->where('c.customerId = :customerId')
         ->setParameter('customerId', $customerId);
      //return $qb->getQuery()->getArrayResult();      
      return $qb->getQuery()->getResult();      

    }
    

    public function getPaymentQuery()
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('p','c','u')
           ->from('Invetico\BankBundle\Entity\Payment', 'p')
           ->leftJoin('p.customer','c')
           ->leftJoin('p.user', 'u');
        return $qb;
    }   

}