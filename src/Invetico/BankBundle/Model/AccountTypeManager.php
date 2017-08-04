<?php

namespace Invetico\BankBundle\Model;

class AccountTypeManager implements AccountTypeManagerInterface
{
    public function __construct(){}

    public function getAccountTypes()
    {
        $checking = new \Invetico\BankBundle\Entity\CheckingAccount;
        $savings = new \Invetico\BankBundle\Entity\SavingsAccount;
        $investment = new \Invetico\BankBundle\Entity\FixedDepositAccount;
        return compact('checking','savings','investment');
    }

    public function getAccountType($type)
    {
        foreach ($this->getAccountTypes() as $key => $value) {
            if($type == $key){
                return $value;
            }
        }
        throw new \InvalidArgumentException("Wrong account type (%s) provided",$type);
    }	
}