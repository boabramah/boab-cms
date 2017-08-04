<?php

namespace Invetico\UserBundle\Exception;

class InvalidTokenException extends \Exception
{
	public function getStatusCode()
	{
		return 500;
	}
}