<?php
namespace Invetico\BankBundle\Entity;

interface TransactionInterface
{
	public function getAmount();	
	
	public function setAmount($amount);	

	public function processAmount($amount);
}
