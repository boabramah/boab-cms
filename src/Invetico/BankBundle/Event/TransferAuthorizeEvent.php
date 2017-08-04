<?php

namespace Invetico\BankBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;

class TransferAuthorizeEvent extends Event
{
	private $transfer;
	private $customer;

	public function __construct($transfer)
	{
		$this->transfer = $transfer;
	}

	public function getTransfer()
	{
		return $this->transfer;
	}


	public function setTransfer($transfer)
	{
		$this->transfer = $transfer;
	}


	public function setCustomer($customer)
	{
		$this->customer = $customer;
	}

	public function getCustomer()
	{
		return $this->customer;
	}

}