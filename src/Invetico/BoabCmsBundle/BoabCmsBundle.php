<?php

namespace Invetico\BoabCmsBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Invetico\BoabCmsBundle\DependencyInjection\Compiler\RouteLoaderPass;
use Invetico\BoabCmsBundle\DependencyInjection\Compiler\ServiceLoaderPass;
use Invetico\BoabCmsBundle\DependencyInjection\Compiler\EntityManagerPass;
use Invetico\BoabCmsBundle\DependencyInjection\Compiler\AppConfigurationPass;
use Invetico\BoabCmsBundle\DependencyInjection\Compiler\ViewRendererPass;
use Invetico\BoabCmsBundle\DependencyInjection\Compiler\RoutingResolverPass;
use Invetico\BoabCmsBundle\DependencyInjection\Compiler\ShortcodeLoaderPass;
use Invetico\BoabCmsBundle\DependencyInjection\Compiler\SerializerPass;
use Invetico\BoabCmsBundle\DependencyInjection\Compiler\ContentTypeManagerResolverPass;
use Invetico\BoabCmsBundle\DependencyInjection\Compiler\MenuResolverPass;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class BoabCmsBundle extends Bundle
{
	public function boot()
	{
		// Set logging dir for monolog
		$logger = $this->container->get('logger');
		$logFile = $this->container->getParameter('kernel.logs_dir').'/log.txt';
		$logger->pushHandler(new StreamHandler($logFile, Logger::WARNING));
	}


	private function getCachedRoutes($cacheDir)
	{
		$file = $cacheDir.'/routes.txt';
        return unserialize(file_get_contents($file));
	}


	public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new RoutingResolverPass());
        $container->addCompilerPass(new ServiceLoaderPass());
        $container->addCompilerPass(new RouteLoaderPass());
        $container->addCompilerPass(new ShortcodeLoaderPass());
        $container->addCompilerPass(new SerializerPass());
        $container->addCompilerPass(new ContentTypeManagerResolverPass());
        $container->addCompilerPass(new MenuResolverPass());
    }


    public function getAlias()
	{
		return 'boabcms_bundle';
	}


    public static function getRouteConfiguration()
    {
        return [__DIR__.'/Resources/config/routing/routes.xml'];
    }	


	public static function getMenuConfiguration()
	{
		return __DIR__ .'/Resources/config/menu.php';
	}    

}
