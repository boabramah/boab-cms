<?php

namespace Invetico\BankBundle\Api\OfficerTransaction;

class PaymentCollection implements \JsonSerializable
{
	private $payments = [];
	private $totalAmount = '0.00';
	private $totalNominalAmount;

    use \Utils\JsonSerialisable;

	public function addPayment(PaymentApiInterface $payment)
	{
		$this->payments[] = $payment;
		$this->totalNominalAmount += $payment->getNominalAmount();
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

	public function getPayments()
	{
		return $this->payments;
	}

}