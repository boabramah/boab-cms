<?php

namespace Invetico\BoabCmsBundle\Api\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\User\UserInterface;

class JWTCreatedListener
{
	private $requestStack;

	public function __construct(RequestStack $request)
	{
		$this->requestStack = $request;
	}

	/**
	 * @param JWTCreatedEvent $event
	 *
	 * @return void
	 */
	public function onJWTCreated(JWTCreatedEvent $event)
	{
	    $request = $this->requestStack->getCurrentRequest();

	    $payload = $event->getData();
		$user = $event->getUser();

		if (!$user instanceof UserInterface) {
		    return;
		}

    	$payload['ip'] = $request->getClientIp();
    	$payload['userId'] = $user->getId();
    	$event->setData($payload);		
	}	
}