<?php

namespace Invetico\BankBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="account_savings")
 * @ORM\Entity(repositoryClass="Invetico\BankBundle\Repository\AccountRepository")
 */
class SavingsAccount extends Account implements SavingsAccountInterface
{
    public function getDefaultAccountName()
	{
		return 'Diamon Saver Account';
	}

    public function getAccountTypeId()
    {
        return 'savings';
    }

    public function getAccountTypeLabel()
    {
        return 'Savings';
    }   
    
}
