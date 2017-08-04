<?php

namespace Invetico\BoabCmsBundle\Api\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Invetico\BoabCmsBundle\Api\Exception\ApiException;

class ApiExceptionListener 
{	
	private $serializer;

	private $requestFormats = ['json','xml'];

	public function __construct(SerializerInterface $serializer)
	{
		$this->serializer = $serializer;
    }

	public function onKernelException(GetResponseForExceptionEvent $event) 
	{
		$request = $event->getRequest();
		$exception = $event->getException();
		$format = $request->getContentType();
		if(!$exception instanceof ApiException){
			return;
		}
		/*
		if(!in_array($format, $this->requestFormats)){
			return;
		}
		*/
		$data = $this->serializer->normalize($exception, $format);
		$response = new JsonResponse($data); 
		$response->setStatusCode($data['code']);
		$event->setResponse($response);
			
	}
	
}