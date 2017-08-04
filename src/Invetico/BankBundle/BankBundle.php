<?php

namespace Invetico\BankBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Bundle\UserBundle\DependencyInjection\Compile\SecurityConfigPass;
use Bundle\UserBundle\DependencyInjection\Compile\OAuthProviderConfigPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;


class BankBundle extends Bundle
{
	public function boot(){}


	public function build(ContainerBuilder $container)
    {
        parent::build($container);

        //$container->addCompilerPass(new SecurityConfigPass());
		//$container->addCompilerPass(new OAuthProviderConfigPass());
    }

	
	public function getAlias()
	{
		return 'account_bundle';
	}


	public static function getServiceConfiguration()
	{
		return [__DIR__.'/Resources/config/services.xml'];
	}


	public static function getRouteConfiguration()
	{
		return [
			__DIR__.'/Resources/config/routing/routes.xml'
			//__DIR__.'/Resources/config/routing/account.xml'
		];
	}


	public static function getMenuConfiguration()
	{
		return __DIR__ .'/Resources/config/menu.php';
	}
}
