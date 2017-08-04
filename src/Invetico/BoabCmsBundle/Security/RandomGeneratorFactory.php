<?php

namespace Invetico\BoabCmsBundle\Security;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class RandomGeneratorFactory
{
	public static function getGenerator($strength='')
	{
		$factory = new \RandomLib\Factory;
		return $factory->getMediumStrengthGenerator();
	}
}