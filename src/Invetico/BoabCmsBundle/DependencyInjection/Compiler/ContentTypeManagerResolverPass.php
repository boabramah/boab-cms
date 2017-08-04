<?php

/*
 *
 * (c) Ernest Boabramah <boabramah@yahoo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Invetico\BoabCmsBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * Adds tagged content.type_manager services to routing.resolver service
 *
 * @author Ernest Boabramah <boabramah@yahoo.com>
 */
class ContentTypeManagerResolverPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (false === $container->hasDefinition('content_type_manager')) {
            return;
        }

        $definition = $container->getDefinition('content_type_manager');
        foreach ($container->findTaggedServiceIds('content.type_manager') as $id => $attributes) {
            $definition->addMethodCall('addContentType', array(new Reference($id)));
        }
    }
}
