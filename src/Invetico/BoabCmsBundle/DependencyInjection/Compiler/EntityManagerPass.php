<?php

namespace Ivetico\BoabCmsBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;


class EntityManagerPass implements CompilerPassInterface
{
	public function process(ContainerBuilder $container)
    {
        $entityPaths = array();
        foreach($container->getBundles() as $bundle){
        	array_push($entityPaths, $bundle->getEntityPath());
        }
        $container->setParameter('entity_paths', $entityPaths);
    }
}
