<?php

namespace Invetico\UserBundle\DependencyInjection\Compile;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\Config\Resource\FileResource;

use Symfony\Component\Routing\RouteCollection;


class OAuthProviderConfigPass implements CompilerPassInterface
{
	public function process(ContainerBuilder $container)
    {
        $file = dirname(dirname(__DIR__)).'/Config/providers.php';
        $container->setParameter('oauth_providers_config', $file);
        $securityContext = $container->getDefinition('user_controller');
        $securityContext->addMethodCall('setConfigFile', array('%oauth_providers_config%'));

        $container->addResource(new FileResource($file));
    }

}
