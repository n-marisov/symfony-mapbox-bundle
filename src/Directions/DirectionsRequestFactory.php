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


    public function create( array $waypoints ):DirectionsRequest
    {
        return (new DirectionsRequest($waypoints))
            ->setProfile($this->data["profile"])
            ->setAlternatives($this->data["alternatives"])
            ->setSteps($this->data["steps"])
            ->setGeometries($this->data["geometries"])
            ;
    }


}