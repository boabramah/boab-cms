<?php

namespace Invetico\BankBundle\Api\Officer;


class Officer implements OfficerApiInterface, \JsonSerializable
{
	private $officerName;
	private $amount;
	private $nominalAmount;

	use \Utils\JsonSerialisable;

	public function __construct($records)
	{
		$this->officerName = $records[0]->getFullName();
		$this->setAmount($records['total_amount']);
	}

	public function setAmount($amount)
	{
		$this->nominalAmount = $amount;
		$this->amount = number_format($amount, 2, '.', ',');
	}	

	public function getAmount()
	{
		return $this->amount;
	}

	public function getNominalAmount()
	{
		return $this->nominalAmount;
	}

	public function getOfficerName()
	{
		return $this->officerName;
	}

}