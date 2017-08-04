<?php

namespace Invetico\BoabCmsBundle\Api\Normalizer;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Invetico\BoabCmsBundle\Validation\Exception\ValidationException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExceptionNormalizer implements NormalizerInterface
{

	public function normalize($exception, $format = null, array $context = [])
	{
		//die(get_class($exception));
		$code = ($exception instanceof HttpExceptionInterface) ? $exception->getStatusCode() : $exception->getCode();
		$payload = [
			"code"=>$code,
			"status"=>"error",			
			"message"=>$exception->getMessage(),
		];
		if($exception instanceof ValidationException){
			$payload['errors'] = $exception->getErrors();
			$payload['data'] = $exception->getData();
		}

		if($exception instanceof NotFoundHttpException){
			$payload['message'] = 'The resource you requested does not exist';
		}

		if($payload['code'] == 0){
			$payload['code'] = 400;
		}

		return $payload;
	}

	public function supportsNormalization($data, $format = null)
	{
		return $data instanceof \Exception;
	}	

}