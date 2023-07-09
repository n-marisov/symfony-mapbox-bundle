<?php

namespace Maris\Symfony\Mapbox\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
     const DEFAULT_DIRECTIONS_REQUEST = [
        "profile" => "driving",
        "geometries" => "geojson",
        "steps" => true,
        "alternatives" => true,
        "exclude" => [
            "points" => [],
            "motorway" => false,
            "toll" => false,
            "ferry" => false,
            "unpaved" => false,
            "cash_only_tolls" => false,
            ]
    ];


    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('mapbox');
        $treeBuilder->getRootNode()
            ->children()
                # АПИ ключ
                ->scalarNode('api_token')->end()
                # Настройки для сервиса получения маршрута
                ->arrayNode("directions")
                    ->children()

                        ->arrayNode("request")
                            ->children()
                                # Вид маршрута
                                ->enumNode("profile")
                                    ->values(["driving","driving-traffic","walking","cycling"])
                                    ->defaultValue( self::DEFAULT_DIRECTIONS_REQUEST["profile"] )
                                ->end()

                                # Тип возвращаемой геометрии
                                ->enumNode("geometries")
                                    ->values([ "geojson", "polyline", "polyline6" ])
                                    ->defaultValue( self::DEFAULT_DIRECTIONS_REQUEST["geometries"] )
                                ->end()

                                # Указывает нужно ли возвращать шаги маршрута
                                ->booleanNode("steps")->defaultValue( self::DEFAULT_DIRECTIONS_REQUEST["steps"] )->end()

                                # Нужно ли искать более одного маршрута
                                ->booleanNode("alternatives")->defaultValue( self::DEFAULT_DIRECTIONS_REQUEST["steps"] )->end()


                                ->arrayNode("exclude")
                                    ->children()
                                        ->booleanNode('motorway')->defaultFalse()->end()
                                        ->booleanNode('toll')->defaultFalse()->end()
                                        ->booleanNode('ferry')->defaultFalse()->end()
                                        ->booleanNode('unpaved')->defaultFalse()->end()
                                        ->booleanNode('cash_only_tolls')->defaultFalse()->end()

                                        ->arrayNode('points')
                                        ->arrayPrototype()
                                        ->children()

                                            ->floatNode("lat")->min(-90.0)->max(90.0)->end()
                                            ->floatNode("long")->min(-180.0)->max(180.0)->end()

                                        ->end()
                                        ->end()
                                        ->end()

                                    ->end()
                                ->end()


                            ->end()
                        ->end()
                    ->end()
                ->end()

            ->end()
        ->end();

        return $treeBuilder;
    }
}
