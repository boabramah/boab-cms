<?php

namespace Invetico\BankBundle\Api\Normalizer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Invetico\BankBundle\Entity\TransactionInterface;

class TransactionNormalizer implements NormalizerInterface
{
	private $request;
	private $routes = ['api_account_transactions','api_transaction'];

	public function __construct(RequestStack $requestStack)
	{
		$this->request = $requestStack->getCurrentRequest();
	}

	public function normalize($transaction, $format = null, array $context = [])
	{
		$data = [
			'id' => $transaction->getId(),
			'description' => $transaction->getDescription(),
			'createdDate' => $transaction->getDateCreated(),
			'balance' => $transaction->getBalance(),
			'amount' => $transaction->getAmount(),
			'type'=>$transaction->getTransactiontype()
		];
		if('api_transaction' == $this->request->get('_route')){
			$data['account'] = [
				'name'=>$transaction->getAccount()->getAccountName(),
				'number'=>$transaction->getAccount()->getAccountNumber()
			];			
		}

		return $data;
	}


	public function supportsNormalization($object, $format = null)
	{
		return in_array($this->request->get('_route'), $this->routes) AND $object instanceof TransactionInterface;
	}

}