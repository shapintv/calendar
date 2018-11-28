<?php

declare(strict_types=1);

namespace Shapin\Calendar\Configuration;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class CalendarConfiguration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $node = $treeBuilder->root('calendar');

        $node
            ->children()
                ->scalarNode('product_identifier')
                    ->isRequired(true)
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
