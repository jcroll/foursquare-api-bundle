<?php

namespace Jcroll\FoursquareApiBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('jcroll_foursquare_api');

        $rootNode
            ->children()
                ->scalarNode('client_key')->end()
                ->scalarNode('client_secret')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
