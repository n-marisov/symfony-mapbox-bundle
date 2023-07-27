<?php

namespace Maris\Symfony\Mapbox\Service;

use Maris\Symfony\Direction\Entity\Direction;
use Maris\Symfony\Geo\Entity\Location;
use Maris\Symfony\Geo\Service\PolylineEncoder;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 *
 */
class MapboxDirectionService implements \Maris\Symfony\Direction\Interfaces\DirectionServiceInterface
{
    const URI = "https://router.project-osrm.org/route/v1/driving/";

    protected HttpClientInterface $client;

    protected PolylineEncoder $encoder;


    public function __construct( HttpClientInterface $client,  PolylineEncoder $encoder )
    {
        $this->client = $client->withOptions([
            'base_uri' => self::URI,
            'query'=>[
                "access_token"=>"pk.eyJ1IjoibWFyaXNvdiIsImEiOiJjbDFibTN3YzAxcm80M2twZmoxODdpeWl3In0.8bLQ-4vjM5WY_7Lq5md8kA"
            ],
            "headers"=>[
                "Content-Type" => "application/x-www-form-urlencoded"
            ]
        ]);
        $this->encoder = $encoder;
    }

    public function getDirection( array $coordinates, array $options ): Direction
    {
        $response = $this->client->request("POST","",[
            "body"=>[
                "coordinates" => implode(";",array_map(function ( Location $location ){
                    return "{$location->getLongitude()},{$location->getLatitude()}";
                },$coordinates)),
                "overview" => false,
                "step" => true
            ]
        ]);

        dd($response);
    }


}