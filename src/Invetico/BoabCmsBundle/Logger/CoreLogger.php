<?php

namespace Invetico\BoabCmsBundle\Logger;


use Psr\Log\LoggerInterface;
use Monolog\Logger;

class CoreLogger extends Logger implements LoggerInterface
{
	public function emergency($message, array $context = array())
	{
		parent::addEmergency($message,$context);
	}
	
	public function critical($message, array $context = array())
	{
		parent::addCritical($message,$context);
	}
	
	public function error($message, array $context = array())
	{
		parent::addError($message,$context);
	}
	
	public function warning($message, array $context = array())
	{
		parent::addWarning($message,$context);
	}
	
	public function log($level, $message, array $context = array())
	{
		//parent::addWarning($message,$context);
	}
}