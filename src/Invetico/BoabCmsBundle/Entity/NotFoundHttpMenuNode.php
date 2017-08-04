<?php

namespace Invetico\BoabCmsBundle\Entity;

use Symfony\Cmf\Component\Routing\RouteObjectInterface;
use Invetico\BoabCmsBundle\Entity\Menu;

class NotFoundHttpMenuNode extends Menu
{
	const CONTROLLER = 'content_controller:showAction';

	const ROUTE_NAME = 'rout_not_found';

	const TEMPLATE = 'PageBundle:Page:page_not_found';

	public function getMessage()
	{
		return 'The page you are looking for does not exist or is no longer available';
	}

	public function getController()
	{
		return self::CONTROLLER;
	}

	public function getRouteName()
	{
		return self::ROUTE_NAME;
	}

	public function getTemplate()
	{
		return self::TEMPLATE;
	}
}