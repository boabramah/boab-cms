<?php
namespace Invetico\BankBundle\Repository;

use Invetico\BoabCmsBundle\Repository\BaseRepository;
use Doctrine\DBAL\Types\Type;
use Symfony\Component\Security\Core\User\UserInterface;

class AccountRepository extends BaseRepository implements AccountRepositoryInterface
{
	public function findAccountByCustomer(UserInterface $customer)
	{
		return $this->getAccountQuery()
		       ->where('c.id = :customerId')
		       ->setParameter('customerId', $customer->getId())
		       ->getQuery()
		       ->getResult();    		
	}


	public function accountIsCreated()
	{
        return $this->_em->createQueryBuilder()
            ->select('COUNT(c.id)')
            ->from('BankBundle:Account', 'c')
            ->where('c.accountNumber = :accountNumber')
            ->setParameter('accountNumber', $accountNumber)
            ->getQuery()
            ->getSingleScalarResult();		           		
	}


	public function findAccountsInArray($array)
	{
		return $this->getAccountQuery()
			   ->where('a.accountNumber IN (:accountNumber)')
			   ->setParameter('accountNumber', $array)
			   ->getQuery()
			   ->getArrayResult();       
	}


	public function findAccountByCustomerId($customerId)
	{
		return $this->getAccountQuery()
		        ->where('c.id = :customerId')
		        ->setParameter('customerId', $customerId)
		        ->getQuery()
		        ->getResult();          
	}  


	public function findAccountsByCustomerId($customerId)
	{
		return $this->getAccountQuery()
			   ->where('c.id = :customerId')
			   ->setParameter('customerId', $customerId)
			   ->getQuery()
			   ->getResult();          
	}    


	public function findByAccountNumber($accountNumber)
	{
		return $this->getAccountQuery()
			   ->where('a.accountNumber = :accountNumber')
			   ->setParameter('accountNumber', $accountNumber)
			   ->getQuery()
			   ->getOneOrNullResult();   	
	}


	public function findTotalAccountBalanace()
	{
		$qb = $this->_em->createQueryBuilder();
		return $qb->select('SUM(a.balance) as total_balance')
		->from('BankBundle:Account', 'a')
		->getQuery()
		->getSingleScalarResult();       
	}


	public function findCustomerTotalAccountBalanace($customerId)
	{
		$qb = $this->_em->createQueryBuilder();
		return $qb->select('SUM(a.balance) as total_balance')
		->from('BankBundle:Account', 'a')
		->leftJoin('a.customer','c')
		->where('c.id = :customerId')
		->setParameter('customerId', $customerId)
		->getQuery()
		->getSingleScalarResult();       
	}       


	public function getAccountQuery()
	{
		$qb = $this->_em->createQueryBuilder();
		$qb->select('a','c')
		->from('BankBundle:Account', 'a')
		->leftJoin('a.customer','c');
		return $qb;
	} 
}