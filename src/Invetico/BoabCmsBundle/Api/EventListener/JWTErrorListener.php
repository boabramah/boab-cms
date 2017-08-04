<?php
namespace Invetico\BoabCmsBundle\Api\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;
use Symfony\Component\HttpFoundation\JsonResponse;

class JWTErrorListener
{
	/**
	 * @param JWTNotFoundEvent $event
	 */
	public function onJWTNotFound(JWTNotFoundEvent $event)
	{
	    $data = [
	    	'code'=>403,
	        'status'  => '403 Forbidden',
	        'message' => 'Missing token',
	    ];

	    $response = new JsonResponse($data, 403);

	    $event->setResponse($response);
	}	
}