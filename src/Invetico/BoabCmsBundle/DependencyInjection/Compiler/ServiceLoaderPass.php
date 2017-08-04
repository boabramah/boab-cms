<?php

namespace Invetico\BoabCmsBundle\DependencyInjection\Compiler;


use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Loader\IniFileLoader;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Loader\ClosureLoader;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\Config\Loader\DelegatingLoader;


class ServiceLoaderPass implements CompilerPassInterface
{
	protected $container;
	protected $loader;

	public function process(ContainerBuilder $container)
	{
		$this->container = $container;
        $locator = new FileLocator($container->getParameter('kernel.root_dir'));
        $this->loader = $this->getLoader($container, $locator);
        foreach ($container->getParameter('kernel.bundles') as $bundle){    
            $this->loadBundleService($container, $bundle);
        }
	}


    public function loadBundleService($container, $bundle)
    {

        if(!is_callable("$bundle::getServiceConfiguration")){
            return ;
        }
        $files = (array)$bundle::getServiceConfiguration();
        foreach ( $files as $file ) {
            $container->addResource($this->loadFile($file));
        }
    }


	private function getAbsoluteFilesForBundle($bundle, $files)
    {
        $reflection = new \ReflectionClass($bundle);
        $dir = str_replace('\\', '/', dirname($reflection->getFilename()).'/');
        return array_map(function($file)use($dir){
            return $dir.$file;
        }, $files); 
    }


    private function loadFile( $file )
    {
        if (!file_exists($file) && !is_readable($file) ){
            throw new \InvalidArgumentException(sprintf('The service configuration file ( %s )is not readable',$file));
        }
        $this->loader->load( $file );
        return new FileResource($file);
    }


    private function getLoader(ContainerBuilder $container, FileLocator $locator)
    {
        $resolver = new LoaderResolver(array(
            new XmlFileLoader($container, $locator),
            new YamlFileLoader($container, $locator),
            new IniFileLoader($container, $locator),
            new PhpFileLoader($container, $locator),
            new ClosureLoader($container),
        ));
        return new DelegatingLoader($resolver);
    }

}