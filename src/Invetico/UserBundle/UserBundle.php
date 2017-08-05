<?php

namespace Invetico\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;


class UserBundle extends Bundle
{
	public function boot(){}

	
	public function getAlias()
	{
		return 'user_bundle';
	}

	public static function getMenuConfiguration()
	{
		return __DIR__ .'/Resources/config/menu.php';
	}
}
