<?php

namespace Invetico\BankBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;

class TransferCreatedEvent extends Event
{
	private $transfer;

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

}