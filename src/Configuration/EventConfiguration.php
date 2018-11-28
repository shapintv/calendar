<?php

declare(strict_types=1);

namespace Shapin\Calendar\Configuration;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class EventConfiguration implements ConfigurationInterface
{
    protected function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $node = $treeBuilder->root('event');

        return $node;
    }
}
