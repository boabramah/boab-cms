<?php

namespace Invetico\UserBundle\Routing;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\XmlFileLoader;


class UserRoutingLoader
{
	public function getRoutes()
	{
		// look inside *this* directory
		$locator = new FileLocator(__DIR__.'/../Config');
		$loader = new XmlFileLoader($locator);
		$collection = $loader->load('routes.xml');
		return $collection;
	}
}