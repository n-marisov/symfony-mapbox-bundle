<?php

namespace Maris\Symfony\Mapbox;

use Maris\Symfony\Mapbox\DependencyInjection\MapboxExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class MapboxBundle extends AbstractBundle{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new MapboxExtension();
    }
    /*public function getPath(): string
    {
        return dirname(__DIR__);
    }*/
}