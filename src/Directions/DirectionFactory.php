<?php

namespace Maris\Symfony\Mapbox\Directions;

use Doctrine\Common\Collections\ArrayCollection;
use Maris\Symfony\Direction\Entity\Direction;
use Maris\Symfony\Direction\Factory\DirectionFactory as Factory;



class DirectionFactory
{
    protected Factory $factory;

    /**
     * @param Factory $factory
     */
    public function __construct( Factory $factory = new Factory() )
    {
        $this->factory = $factory;
    }

    public function __invoke( array $data, array $waypoints ):Direction
    {
        return $this->factory->create( $data, new ArrayCollection( $waypoints ) );
    }


}