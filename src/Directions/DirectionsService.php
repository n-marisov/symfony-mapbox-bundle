<?php

namespace Maris\Symfony\Mapbox\Directions;

use Maris\Symfony\Direction\Entity\Direction;
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
     * @param string $apiKey
     * @param HttpClientInterface $client
     * @param DirectionsRequestFactory $requestFactory
     */
    public function __construct( string $apiKey,  HttpClientInterface $client, DirectionsRequestFactory $requestFactory )
    {
        $this->apiKey = $apiKey;
        $this->requestFactory = $requestFactory;

        $this->factory = new DirectionFactory();
        $this->client = $client->withOptions([
            'base_uri' => self::URI
        ]);
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