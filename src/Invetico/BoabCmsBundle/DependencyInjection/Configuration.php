<?php

namespace Invetico\BoabCmsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Yaml\Parser;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('boab_cms');

        $yaml = new Parser();
        $config = $yaml->parse(file_get_contents(__DIR__.'/../Resources/config/config.yml'));
//print_r($config);
//die;
        $rootNode
            ->children()
                ->arrayNode('pagination')
                    ->children()
                        ->integerNode('entries_per_page')->end()
                        ->integerNode('links_per_page')->end()
                    ->end()
                ->end()
                ->arrayNode('content_types')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('entity')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                            ->scalarNode('add_template')
                                ->defaultValue($config['content_types']['content']['add_template'])
                            ->end()
                            ->scalarNode('edit_template')
                                ->defaultValue($config['content_types']['content']['edit_template'])
                            ->end()
                            ->scalarNode('show_template')
                                ->defaultValue($config['content_types']['content']['show_template'])
                            ->end()
                            ->scalarNode('list_template')
                                ->defaultValue($config['content_types']['content']['list_template'])
                            ->end()
                            ->scalarNode('list_layout_type')
                                ->defaultValue($config['content_types']['content']['list_layout_type'])
                            ->end()
                            ->scalarNode('show_layout_type')
                                ->defaultValue($config['content_types']['content']['show_layout_type'])
                            ->end()
                            ->scalarNode('form_validator')
                                ->defaultValue($config['content_types']['content']['form_validator'])
                            ->end()
                            ->scalarNode('description')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                        ->end()
                    ->end() // twitter
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
