<?php

namespace Maris\Symfony\Mapbox\Directions;

/**
 * Создает объект запроса для сервиса получения маршрута
 */
class DirectionsRequestFactory
{
    protected array $data;
    public function __construct( array $defaultRequestData )
    {
        $this->data = $defaultRequestData;
    }


}