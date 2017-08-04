<?php
namespace Invetico\UserBundle\Repository;

use Invetico\BoabCmsBundle\Repository\BaseRepository;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Invetico\UserBundle\Entity\User;

class UserRepository extends BaseRepository implements UserLoaderInterface, UserRepositoryInterface, UserProviderInterface
{  
    public  function findAllUsers($page)
    {
        $qb = $this->getUserQuery();
        $qb->orderBy('u.firstname', 'ASC');
        return $this->paginate($qb->getQuery(), $page);
    }


    public function getUserQuery()
    {
    	$qb = $this->_em->createQueryBuilder();
        $qb->select('u')
           ->from('UserBundle:User', 'u');
          return $qb;         
    }


    public function findUserById($id)
    {
    	$qb = $this->getUserQuery();
    	$qb->where("u.id = :id")
           ->setParameter('id',$id);

    	return $qb->getQuery()->getOneOrNullResult();
    }

    public function loadUserByUsername($username)
    {
        $qb = $this->getUserQuery();
        $qb->where("u.username = :username OR u.email = :email")
        //  ->andWhere("u.accountStatus = :status")
           ->setParameter('username',$username)
           ->setParameter('email',$username);
        //   ->setParameter('status','active');
        return $qb->getQuery()->getOneOrNullResult(); 
    } 

    public function findUserByUserName($username)
    {
        $qb = $this->getUserQuery();
        $qb->where("u.username = :username")
           ->setParameter('username',$username);
        return $qb->getQuery()->getOneOrNullResult(); 
    }      

    public function refreshUser(UserInterface $user) 
    {
        if (!$this->supportsClass($user)) {
            throw new UnsupportedUserException('User type not supported');
        }
        return $this->loadUserByUsername($user->getUsername());
    }


    public function supportsClass($user)
    {
        return $user instanceof UserInterface;
    } 

}