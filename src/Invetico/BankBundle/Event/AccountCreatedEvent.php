<?php

namespace Invetico\BankBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;

class AccountCreatedEvent extends Event
{
	private $account;

	public function __construct($account)
	{
		$this->account = $account;
	}

	public function getAccount()
	{
		return $this->account;
	}


	public function setAccount($account)
	{
		$this->account = $account;
	}

}