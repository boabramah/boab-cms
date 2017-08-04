<?php

namespace Invetico\UserBundle\Api\Normalizer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Cmf\Component\Routing\ChainRouterInterface;
use Symfony\Cmf\Component\Routing\ChainRouter;

class UserNormalizer implements NormalizerInterface
{
	private $router;

	public function __construct(ChainRouterInterface $router)
	{
		$this->router = $router;
	}

	public function normalize($object, $format = null, array $context = [])
	{
		return [
			'userId' => $object->getUserId(),
			'username' => $object->getUsername(),
			'firstname' => $object->getFirstname(),
			'lastname' => $object->getLastname(),
			'avatar'=> $object->getAvatar()
		];
	}


	public function supportsNormalization($object, $format = null)
	{
		//return false;
		return $object instanceof UserInterface AND !$object->isDetail();
	}

}