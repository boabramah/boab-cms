<?php

namespace Invetico\BankBundle\Api\Account;

class AccountCollection implements \JsonSerializable
{
	private $accounts = [];
	private $totalAccountAmount;

    use \Utils\JsonSerialisable;

	public function addAccount(AccountApiInterface $account)
	{
		$this->accounts[] = $account;
	}

}