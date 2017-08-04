<?php

namespace Invetico\BankBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="account_checking")
 * @ORM\Entity(repositoryClass="Invetico\BankBundle\Repository\AccountRepository")
 */
class CheckingAccount extends Account implements CheckingAccountInterface
{	

    public function getDefaultAccountName()
	{
		return 'Gold Current Account';
	}

    public function getAccountTypeId()
    {
        return 'checking';
    }

    public function getAccountTypeLabel()
    {
        return 'Checking';
    }   
    
}
