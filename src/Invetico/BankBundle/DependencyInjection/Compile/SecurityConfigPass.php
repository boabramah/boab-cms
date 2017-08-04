<?php

namespace Bundle\UserBundle\DependencyInjection\Compile;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\Config\Resource\FileResource;

use Symfony\Component\Routing\RouteCollection;


class SecurityConfigPass implements CompilerPassInterface
{
	public function process(ContainerBuilder $container)
    {
        //exit(__DIR__.'/../../Config');
        $file = dirname(dirname(__DIR__)).'/Config/security.php';
        $container->setParameter('security_config', $file);
        $securityContext = $container->getDefinition('security_listener');
        $securityContext->addMethodCall('setConfigFile', array('%security_config%'));

        $container->addResource(new FileResource($file));
    }

}