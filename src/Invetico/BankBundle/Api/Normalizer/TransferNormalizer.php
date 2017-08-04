<?php

namespace Invetico\BankBundle\Api\Normalizer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Invetico\BankBundle\Entity\TransferInterface;
use Invetico\BankBundle\Entity\Transfer;

class TransferNormalizer implements NormalizerInterface
{
	private $request;

	public function __construct(RequestStack $requestStack)
	{
		$this->request = $requestStack->getCurrentRequest();
	}
	

	public function normalize($transfer, $format = null, array $context = [])
	{
		$data = [
			'id' => $transfer->getId(),			
			'fromAccount' => $transfer->getFromAccount(),
			'toAccount' => $transfer->getToAccount(),
			'transferType' => $transfer->getTransferType(),
			'status' => $transfer->getStatus(),
			'amount' => $transfer->getAmount(),
			'createdDate' => $transfer->getDateCreated('Y-m-d h:i:s'),
			'reference' => $transfer->getReferenceNumber(),			
		];

		return $data;
	}


	public function supportsNormalization($object, $format = null)
	{
		if('api_transfer_show' == $this->request->get('_route')){
			return false;
		}

		return $object instanceof TransferInterface;
	}

}