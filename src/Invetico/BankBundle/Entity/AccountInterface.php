<?php
namespace Invetico\BankBundle\Entity;

interface AccountInterface
{
	public function getDefaultAccountName();	
	
	public function getAccountTypeId();
	
	public function getAccountTypeLabel();
}
