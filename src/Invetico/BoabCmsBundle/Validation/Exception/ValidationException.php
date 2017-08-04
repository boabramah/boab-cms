<?php

namespace Invetico\BoabCmsBundle\Validation\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;

class ValidationException extends HttpException
{
	private $errors;
	private $data = array();

	public function __construct($code, $message, $errors)
	{
		parent::__construct($code,$message);
		$this->errors = $errors;
	}

	public function getErrors()
	{
		return $this->errors;
	}

	public function setData(array $data= array())
	{
		$this->data = $data;
	}

	public function getData()
	{
		return $this->data;
	}
	

	public function getHeaders()
	{

	}
}