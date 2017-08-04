<?php

namespace Invetico\BoabCmsBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;


class SerializerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        /*
        $definition = $container->getDefinition('api.normalizer');
        $services = $container->findTaggedServiceIds('serializer.normalizer');
        foreach ($services as $id => $attributes) {
            $definition->addMethodCall('addNormalizer', array(new Reference($id)));
        } 
        */
        $definition = $container->findDefinition('serializer.normalizer.object');
        $definition->addMethodCall('setCircularReferenceHandler',[new Reference('serializer.circular_reference_handler')]);        
    }
}
