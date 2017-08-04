<?php

namespace Invetico\BankBundle\Repository;

use Bundle\UserBundle\Repository\UserRepository;

class OfficerRepository extends UserRepository implements OfficerRepositoryInterface
{
    public function findAllOfficers($page)
    {
        $qb = $this->getUserQuery();
        $qb->where('u.account_type = :accountType')
           ->orderBy('u.firstname', 'ASC')
           ->setParameter('accountType','officer');
        return $this->paginate($qb->getQuery(), $page, 20);        
    }
}