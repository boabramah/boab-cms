<?php

namespace Invetico\BoabCmsBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\XmlFileLoader;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Loader\AnnotationFileLoader;
use Symfony\Component\Routing\Loader\PhpFileLoader;
use Symfony\Component\Routing\Loader\ClosureLoader;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\Config\Loader\DelegatingLoader;
use Symfony\Component\Config\Resource\FileResource;


class MenuResolverPass implements CompilerPassInterface
{
	private $files = [];

    public function process(ContainerBuilder $container)
    {
        $menuTree = [];

        foreach ( $container->getParameter('kernel.bundles') as $bundle ){
            if(is_callable(array($bundle,'getMenuConfiguration'))){
                $hash = md5($bundle);
                $menuItems = $this->getMenuForBundle( $bundle );
                foreach($menuItems as $key => $item){
                    if($item['position'] == 1){
                        $item['id'] = $hash = $hash.$key;
                        $item['parent_id'] = 0;
                        $menuTree[]  = $item;
                        continue;
                    }
                    $item['id'] = $hash . $key;
                    $item['parent_id'] = $hash;
                    $menuTree[] = $item;
                }
            }
        }

        $this->addResourcesToContainer($container, $this->files);

        //var_dump($menuTree);
        //exit;
        
        $file = $container->getParameter('kernel.cache_dir').'/menu_tree.txt';
        file_put_contents( $file, serialize($menuTree) );
    }


    private function getMenuForBundle($bundle)
    {
        $file = $bundle::getMenuConfiguration();
        if(!file_exists($file) OR !is_readable($file)){
            throw new \Exception(sprintf('This menu configuration file %s is not readable or does not exist', $file)); 
        }
        array_push($this->files, new FileResource($file));
        $menuItems = include $file;
        
        return $menuItems;
    }


    private function addResourcesToContainer($container, array $resources = array())
    {
    	foreach ($resources as $resource) {
    		$container->addResource($resource);
    	}
    }

}