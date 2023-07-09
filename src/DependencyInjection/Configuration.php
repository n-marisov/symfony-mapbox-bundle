<?php

namespace Maris\Symfony\Mapbox\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
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

                    ->end()
                ->end()


                ->arrayNode("request")
                    ->children()
                        # Вид маршрута
                        ->enumNode("profile")
                            ->values(["driving","driving-traffic","walking","cycling"])
                            ->defaultValue("driving")
                        ->end()

                        # Тип возвращаемой геометрии
                        ->enumNode("geometries")
                            ->values([ "geojson", "polyline", "polyline6" ])
                            ->defaultValue("geojson")
                        ->end()


                        # Указывает нужно ли возвращать шаги маршрута
                        ->booleanNode("steps")->defaultValue(true)->end()

                        # Нужно ли искать более одного маршрута
                        ->booleanNode("alternatives")->defaultValue(true)->end()

                        # Список дорог и точек который необходимо исключить из маршрута
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
                            ->defaultValue([])
                        ->end()

                    ->end()

                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
