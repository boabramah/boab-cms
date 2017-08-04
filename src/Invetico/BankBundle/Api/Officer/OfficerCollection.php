<?php

namespace Invetico\BankBundle\Api\Officer;

class OfficerCollection implements \JsonSerializable
{
	private $officers = [];
	private $totalAmount;
	private $totalNominalAmount;

    use \Utils\JsonSerialisable;

	public function addOfficer(OfficerApiInterface $officer)
	{
		$this->officers[] = $officer;
		$this->totalNominalAmount += $officer->getNominalAmount();
		$this->setAmount($this->totalNominalAmount);
	}

	public function setAmount($amount)
	{
		$this->totalAmount = number_format($amount, 2, '.', ',');
	}

	public function getTotalNominalAmount()
	{
		return $this->totalNominalAmount;
	}

	public function getTotalAmount()
	{
		return $this->totalAmount;
	}

	public function getOfficers()
	{
		return $this->officers;
	}

}