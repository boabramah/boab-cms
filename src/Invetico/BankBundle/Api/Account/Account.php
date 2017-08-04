<?php

namespace Invetico\BankBundle\Api\Account;

use Invetico\BankBundle\Entity\CustomerInterface;

class Account implements AccountApiInterface, \JsonSerializable
{
	private $id;
	private $accountId;
	private $accountName;
	private $accountNumber;
	private $officer;
	private $makePaymentUrl;
	private $accountTransactionUrl;
	private $updateAccountUrl;
	private $accountDetailUrl;
	private $deleteAccountUrl;

	use \Utils\JsonSerialisable;

	public function __construct(CustomerInterface $customer)
	{
		$this->id = $customer->getId();
		$this->accountId = $customer->getCustomerId();
		$this->accountName = $customer->getAccountName();
		$this->accountNumber = $customer->getAccountNumber();
		//if(!$customer->getUser()){
			//die($customer->getCustomerId());
		//}
		$this->officer = $customer->getUser()->getFullName();
	}

	public function setMakePaymentUrl($url)
	{
		$this->makePaymentUrl = $url;
	}

	public function setAccountTransactionUrl($url)
	{
		$this->accountTransactionUrl = $url;
	}

	public function setUpdateAccountUrl($url)
	{
		$this->updateAccountUrl = $url;
	}

	public function setAccountDetailUrl($url)
	{
		$this->accountDetailUrl = $url;
	}

	public function setDeleteAccountUrl($url)	
	{
		$this->deleteAccountUrl = $url;
	}
}