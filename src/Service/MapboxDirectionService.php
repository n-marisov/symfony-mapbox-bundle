<?php

namespace Maris\Symfony\Mapbox\Service;

use Maris\Symfony\Direction\Entity\Direction;
use Maris\Symfony\Geo\Entity\Location;
use Maris\Symfony\Geo\Service\PolylineEncoder;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 *
 */
class MapboxDirectionService implements \Maris\Symfony\Direction\Interfaces\DirectionServiceInterface
{
    const URI = "https://api.mapbox.com/directions/v5/mapbox/driving";

    protected HttpClientInterface $client;

    protected PolylineEncoder $encoder;


    public function __construct( string $apiKey, HttpClientInterface $client,  PolylineEncoder $encoder )
    {
        $this->client = $client->withOptions([
            'base_uri' => self::URI,
            'query'=>[
                "access_token" => $apiKey
                //"access_token"=>"pk.eyJ1IjoibWFyaXNvdiIsImEiOiJjbDFibTN3YzAxcm80M2twZmoxODdpeWl3In0.8bLQ-4vjM5WY_7Lq5md8kA"
            ],
            "headers"=>[
                "Content-Type" => "application/x-www-form-urlencoded"
            ]
        ]);
        $this->encoder = $encoder;
    }

    public function getDirection( array $coordinates, array $options ): Direction
    {
        dump( $this->createBody($coordinates) );

            dd( $this->client->request("POST", "", [
                "body" => [
                    "coordinates" => "39.631678,47.223835;39.753482,43.586772",
                    "steps" => "true"
                ]
            ])->toArray());
       // dd($response->getContent());
    }


    protected function createBody( array $coordinates ):string
    {
        $data = [
            "coordinates" => implode(";",array_map(function ( Location $location ){
                return "{$location->getLongitude()},{$location->getLatitude()}";
            },$coordinates)),
            "overview" => "false",
            "step" => "true"
        ];

        $result = "";

        foreach ($data as $k => $v)
            $result .= "$k=$v&";
        return $result;
    }


}