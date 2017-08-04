<?php

namespace Invetico\BoabCmsBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Loader\XmlFileLoader;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Loader\AnnotationFileLoader;
use Symfony\Component\Routing\Loader\PhpFileLoader;
use Symfony\Component\Routing\Loader\ClosureLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\Config\Loader\DelegatingLoader;


class RouteLoaderPass implements CompilerPassInterface
{
	public function process(ContainerBuilder $container)
    {
        $locator = new FileLocator($container->getParameter('kernel.root_dir'));
        $loader = $this->getRouteLoader($locator);
        $routeCollection = new RouteCollection();
        $routeFiles = array();

        foreach ( $container->getParameter('kernel.bundles') as $bundle ){
            $routeFiles = array_merge( $routeFiles, $this->getRoutesForBundle( $bundle ) );
        }

        $this->loadFile( $loader, $routeCollection, $routeFiles );
        $this->addResourcesToContainer( $container, $routeCollection->getResources() );
        $file = $container->getParameter('kernel.cache_dir').'/routes.txt';
        file_put_contents( $file, serialize($routeCollection) );
    }

    private function loadFile($loader, $routeCollection, array $files = array())
    {
        foreach ($files as $file) {
            if (is_file($file)){
                $routeCollection->addCollection($loader->import($file));
            }
        }
    }


    private function getRoutesForBundle( $bundle )
    {
        $reflection = new \ReflectionClass($bundle);
        if(!is_callable([$bundle,'getRouteConfiguration'])){
            return [];
        }
        $routeFiles = (array)$bundle::getRouteConfiguration();
        foreach($routeFiles as $file){
            if(!file_exists($file) || !is_readable($file)){
                 throw new \Exception(sprintf('The routing file %s for the bundle %s does not exist', $file, $bundle));
            }
        }
        return $routeFiles;
    }


    private function addResourcesToContainer($container, array $resources = array())
    {
    	foreach ($resources as $key => $resource) {
    		$container->addResource($resource);
    	}
    }


    private function getRouteLoader(FileLocator $locator)
    {
        $resolver = new LoaderResolver(array(
            new XmlFileLoader($locator),
            new YamlFileLoader($locator),
            new PhpFileLoader($locator),
            new ClosureLoader($locator),
        ));

        return new DelegatingLoader($resolver);
    }
}