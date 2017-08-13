<?php

namespace Invetico\BoabCmsBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;


class ShortcodeLoaderPass implements CompilerPassInterface
{
	public function process(ContainerBuilder $container)
    {
        if (false === $container->hasDefinition('shortcode_manager')) {
            return;
        }

        $definition = $container->getDefinition('shortcode_manager');

        foreach ($container->findTaggedServiceIds('shortcode') as $id => $attributes) {
            $definition->addMethodCall('register', array(new Reference($id)));
        }
    }
}
