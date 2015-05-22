<?php
namespace Snapshoter\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class SnapshoterConfiguration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('snapshoter');

        $rootNode
            ->children()
            ->arrayNode('aws')
            ->children()
            ->scalarNode('key')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('secret')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('region')->isRequired()->cannotBeEmpty()->end()
            ->end()
            ->end()
            ->end();

        return $treeBuilder;
    }

}