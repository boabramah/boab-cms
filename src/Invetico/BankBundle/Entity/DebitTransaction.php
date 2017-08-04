<?php

namespace Invetico\BankBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="Invetico\BankBundle\Repository\AccountRepository")
 */
class DebitTransaction extends Transaction implements DebitTransactionInterface
{
	const TRANS_TYPE = 'debit';

    public function setAmount($amount)
	{
		return $this->setDebitAmount($amount);
	}

    /**
     * Get amount
     * @Groups({"detail", "list"})
     * @return string
     */
    public function getAmount()
    {
        return $this->getDebitAmount();
    }


    public function processAmount($amount)
    {
        $this->account->withdraw($amount);
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