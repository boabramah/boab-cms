<?php

namespace Invetico\BankBundle\Api\OfficerTransaction;

use Invetico\BankBundle\Entity\PaymentInterface;

class Payment implements PaymentApiInterface, \JsonSerializable
{
	private $paymentId;
	private $date;
	private $accountName;
	private $accountNumber;
	private $paymentType;
	private $amount;
	private $nominalAmount;
	private $officer;

	use \Utils\JsonSerialisable;

	public function __construct(PaymentInterface $payment)
	{
		$this->paymentId = $payment->getId();
		$this->date = $payment->getDateCreated();
		$this->accountName = $payment->getCustomer()->getAccountName();
		$this->accountNumber = $payment->getCustomer()->getAccountNumber();
		$this->setAmount($payment->getAmount());
		$this->officer = $payment->getUser()->getFullName();
	}

	public function setPaymentType($paymentType)
	{
		$this->paymentType = $paymentType;
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

	public function getAccountName()
	{
		return $this->accountName;
	}

	public function getAccountNumber()
	{
		return $this->accountNumber;
	}

	public function getPaymentType()
	{
		return $this->paymentType;
	}

	public function getDate()
	{
		return $this->date;
	}

	public function getOfficer()
	{
		return $this->officer;
	}

}