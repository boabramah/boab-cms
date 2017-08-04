<?php
namespace Invetico\UserBundle\Repository;

use Invetico\UserBundle\Entity\User;

class UserApiRepository extends UserRepository implements UserRepositoryInterface
{  
	public function findByUsername($username)
	{
		$qb = $this->getUserQuery();
		return $qb->where("u.username = :username")
		          ->setParameter('username',$username)
		          ->getQuery()->getOneOrNullResult(); 
	} 

	public function findByUserId($userId)
	{
		return $this->getUserQuery()
		            ->where("u.userId = :userId")
		            ->setParameter('userId',$userId)
		            ->getQuery()->getOneOrNullResult(); 
	} 	


	public function findUsers($page)
	{
		$qb = $this->_em->createQueryBuilder();
		return $qb->select("u")
				  ->from('UserBundle:Customer', 'u')
				  ->where('u.occupation IS NOT NULL')           
				  ->setFirstResult(0)
				  ->setMaxResults(self::MAX_RESULTS)
				  ->getQuery()
				  ->getResult();        
	}

	public function findUsersByCriteria($query, $lat, $lng, $radius, $page)
	{
		$qb = $this->getInRadiusQuery(); 
		$qb->from('UserBundle:Employee', 'u')
//           ->where('u.occupation IS NOT NULL')
		->where('u.firstname LIKE :query')
		->orWhere('u.lastname LIKE :query')
		->setParameter('query', $query)           
		->setParameter('lat', $lat)           
		->setParameter('lng', $lng)           
					 //->setParameter('radius', $radius)           
		->setFirstResult(0)
		->setMaxResults(self::MAX_RESULTS); 

		return $qb->getQuery()->getResult();                    
	}

	public function findUsersInRadius($lat, $lng, $radius)
	{
		$qb = $this->getInRadiusQuery(); 
		$qb->from('UserBundle:Customer', 'u')
		->having('distance < :radius')
		->groupBy('distance')
		->setParameter('lat', $lat)
		->setParameter('lng', $lng)
		->setParameter('radius', $radius);      

		return $qb->getQuery()->getResult();        
	} 

	public function getInRadiusQuery(){
		$qb = $this->_em->createQueryBuilder();
		$qb->select("u.id,u.firstname, u.lastname, u.latitude, u.longitude, CONCAT(u.address,',',u.country) as address,
			( 6371 * acos( 
			cos( radians(:lat) ) * 
			cos( radians( u.latitude ) ) * 
			cos( radians( u.longitude ) - radians(:lng) ) + 
			sin( radians(:lat) ) * 
			sin( radians(u.latitude) ) 
			) 
			) AS distance "
			);
		return $qb;
	}                  

}