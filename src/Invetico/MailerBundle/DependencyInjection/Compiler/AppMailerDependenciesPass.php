<?php

namespace Invetico\MailerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;


class AppMailerDependenciesPass implements CompilerPassInterface
{
	public function process(ContainerBuilder $container)
    {
        foreach ($container->findTaggedServiceIds('app.mailer') as $id => $attributes) {
            $definition = $container->getDefinition($id);
            $definition->addMethodCall('setDefault', array(
                new Reference('view_template'), 
                new Reference('swiftmailer.mailer.default'),
                new Reference('router')
                )
            );
        } 
    }
}
