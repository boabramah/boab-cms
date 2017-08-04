<?php

namespace Invetico\BankBundle\Api\Normalizer;

use Symfony\Component\Serializer\Normalizer\SerializerAwareNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Invetico\BankBundle\Entity\AccountInterface;

class AccountNormalizer extends SerializerAwareNormalizer implements NormalizerInterface
{
	private $request;
	private $routes = ['api_accounts','api_account'];

	public function __construct(RequestStack $requestStack)
	{
		$this->request = $requestStack->getCurrentRequest();
	}	

	public function normalize($account, $format = null, array $context = [])
	{
		$data = [
			'accountNumber' => $account->getAccountNumber(),
			'accountName' => $account->getAccountName(),
			'accountType' => $account->getAccountType(),
			'status' => $account->getStatus(),
			'balance' => $account->getBalance()
		];
		if('api_account' == $this->request->get('_route')){
			$data['interestRate'] = '5.7';
			$data['customer'] = $this->serializer->normalize($account->getCustomer(), $format);
		}
		return $data;
	}


	public function supportsNormalization($object, $format = null)
	{
		if(in_array($this->request->get('_route'),$this->routes)){
			return $object instanceof AccountInterface;
		}
	}

}