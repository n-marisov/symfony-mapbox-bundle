<?php

namespace Maris\Symfony\Mapbox\Directions;

use Maris\Symfony\Direction\Entity\Direction;
use Maris\Symfony\Direction\Entity\Waypoint;
use Maris\Symfony\Direction\Service\MapboxDirectionFactory;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Сервис для получения маршрутов.
 */
class DirectionsService
{
    protected const URI = "https://api.mapbox.com/directions/v5/mapbox/";

    protected string $apiKey;
    protected HttpClientInterface $client;

    protected DirectionsRequestFactory $requestFactory;

    protected DirectionFactory $factory;

    /**
     * @param HttpClientInterface $client
     */
    public function __construct( string $apiKey,  HttpClientInterface $client, DirectionsRequestFactory $requestFactory )
    {
        $this->apiKey = $apiKey;
        $this->requestFactory = $requestFactory;
        $this->client = $client->withOptions([
            'base_uri' => self::URI
        ]);

        /*$this->client = HttpClient::create([
            'base_uri' => self::URI,
        ]);*/
    }

    protected function createQuery():string
    {
        return http_build_query([
            "access_token" => $this->apiKey,
            "steps"=>"true",
            "geometries"=>"geojson",
            "overview" => "false"
        ]);
    }
    protected function createUri( array $waypoints ):string
    {
        return implode(";",array_map(function ( Waypoint $waypoint ):string{
                return $waypoint->getOriginal()->getLongitude() .",".$waypoint->getOriginal()->getLatitude();
            },$waypoints)). "?" .$this->createQuery();
    }

    protected function request( DirectionsRequest $request ):?array
    {
        return $this->client->request( "GET", $request->createUri( $this->apiKey ) )->toArray();
    }


    public function __invoke( array|DirectionsRequest $request ):Direction
    {
        $request = (is_a($request,DirectionsRequest::class))
            ? $request : $this->requestFactory->create($request);

        return ($this->factory)( $this->request( $request ), $request->getWaypoints() );
    }
}