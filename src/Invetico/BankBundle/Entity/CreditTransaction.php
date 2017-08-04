<?php

namespace Invetico\BankBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="Invetico\BankBundle\Repository\AccountRepository")
 */
class CreditTransaction extends Transaction implements CreditTransactionInterface
{
    const TRANS_DEFAULT_DESC = 'Direct Cash Deposit';

    const TRANS_TYPE = 'credit';
    
    public function setDescription($description='')
    {
        return parent::setDescription(empty($description) ? self::TRANS_DEFAULT_DESC : $description);
    }	

    public function setAmount($amount)
	{
        return $this->setCreditAmount($amount);
	}

    /**
     * Get amount
     * @Groups({"detail", "list"})
     * @return string
     */
    public function getAmount()
    {
        return $this->creditAmount;
    }


    public function processAmount($amount)
    {
        $this->account->deposit($amount);
        $this->balance = $this->account->getBalance();        
    }

    public function getTransactionType()
    {
        return self::TRANS_TYPE;
    }

    /**
     *
     * @Groups({"detail", "list"})     
     */ 
    public function getType()   
    {
        return $this->getTransactionType();
    }
}
