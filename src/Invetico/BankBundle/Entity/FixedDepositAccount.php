<?php

namespace Invetico\BankBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="account_fixed_deposit")
 * @ORM\Entity(repositoryClass="Invetico\BankBundle\Repository\AccountRepository")
 */
class FixedDepositAccount extends Account implements InvestmentAccountInterface
{

    public function getDefaultAccountName()
	{
		return 'Fixed Deposit Account';
	}

    public function getAccountTypeId()
    {
        return 'investment';
    }

    public function getAccountTypeLabel()
    {
        return 'Investment';
    }   
    
}
