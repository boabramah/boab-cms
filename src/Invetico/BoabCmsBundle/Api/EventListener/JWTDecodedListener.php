<?php

namespace Invetico\BoabCmsBundle\Api\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;

class JWTDecodedListener
{
	private $requestStack;

	public function __construct($request)
	{
		$this->requestStack = $request;
	}

	/**
	 * @param JWTDecodedEvent $event
	 *
	 * @return void
	 */
	public function onJWTDecoded(JWTDecodedEvent $event)
	{
	    $request = $this->requestStack->getCurrentRequest();
	    
	    $payload = $event->getPayload();

	    $request->attributes->set('userId',$payload['userId']);
	    $request->attributes->set('username',$payload['username']);


	    if (!isset($payload['ip']) || $payload['ip'] !== $request->getClientIp()) {
	        //die($payload['username']);
	        //$event->markAsInvalid();
	    }
	}	
}