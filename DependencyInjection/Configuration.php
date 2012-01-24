<?php

namespace SG\RateBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('sg_rate');

        $rootNode
            ->children()
                ->arrayNode('model')
                    ->isRequired()
                    ->cannotBeEmpty()
                    ->children()
                        ->scalarNode('rate_class')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('min_rate_score')->defaultValue(0)->end()
                        ->scalarNode('max_rate_score')->defaultValue(5)->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
