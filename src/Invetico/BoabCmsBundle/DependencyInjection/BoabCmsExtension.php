<?php

/*
 * This file is part of the Symfony package.
 *
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Invetico\BoabCmsBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Config\FileLocator;


class BoabCmsExtension extends Extension
{
    /**
     * Responds to the app.config configuration parameter.
     *
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {

        $locator = new FileLocator(__DIR__.'/../Resources/config');
        $loader = new XmlFileLoader($container, $locator);
        $loader->load('api.xml');
        $loader->load('core.xml');
        $loader->load('content.xml');
        $loader->load('menu.xml');
        $loader->load('shortcode.xml');

        $yamlLoader = new YamlFileLoader($container, $locator);
        $yamlLoader->load('content.yml');
        $yamlLoader->load('api.yml');

        //$contentTypes = $configs['content_types'];
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('boab_cms.content_types', $config['content_types']);
        $container->setParameter('boab_cms.pagination', $config['pagination']);

        //print_r($config);
        //die;
    }

    public function getAlias()
    {
        return 'boab_cms';
    }
}
