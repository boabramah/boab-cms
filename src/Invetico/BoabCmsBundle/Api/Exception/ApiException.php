<?php 

namespace Invetico\BoabCmsBundle\Api\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiException extends HttpException
{
	public function __construct($statusCode, $message=null, \Exception $previous=null, $headers=[], $code=0)
	{
		parent::__construct($statusCode, $message, $previous, $headers, $code);
	}

}