<?php

namespace Maris\Symfony\Mapbox\Directions;

use Maris\Symfony\Direction\Entity\Waypoint;

class DirectionsRequest
{
    protected string $profile = "driving-traffic";
    protected string $geometries = "geojson";
    protected bool $steps = true;
    protected bool $alternatives = true;

    protected array $waypoints;

    /**
     * @param array<Waypoint> $waypoints
     */
    public function __construct( array $waypoints )
    {
        $this->waypoints = $waypoints;
    }

    public function getQuery( string $apiKey ):string
    {
        return http_build_query([
            "access_token" => $apiKey,
            "steps"=> ($this->steps) ? "true" : "false" ,
            "alternatives"=> ($this->alternatives) ? "true" : "false" ,
            "overview" => "false",
            "geometries"=> $this->geometries ,
        ]);
    }


    public function createUri( string $apiKey ):string
    {
        return $this->profile."/".$this->getCoordinates()."?".$this->getQuery( $apiKey );
    }


    /**
     * @return string
     */
    public function getProfile(): string
    {
        return $this->profile;
    }

    /**
     * @param string $profile
     * @return $this
     */
    public function setProfile(string $profile): self
    {
        $this->profile = $profile;
        return $this;
    }

    /**
     * @return string
     */
    public function getGeometries(): string
    {
        return $this->geometries;
    }

    /**
     * @param string $geometries
     * @return $this
     */
    public function setGeometries(string $geometries): self
    {
        $this->geometries = $geometries;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSteps(): bool
    {
        return $this->steps;
    }

    /**
     * @param bool $steps
     * @return $this
     */
    public function setSteps(bool $steps): self
    {
        $this->steps = $steps;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAlternatives(): bool
    {
        return $this->alternatives;
    }

    /**
     * @param bool $alternatives
     * @return $this
     */
    public function setAlternatives(bool $alternatives): self
    {
        $this->alternatives = $alternatives;
        return $this;
    }

    /**
     * @return string
     */
    public function getCoordinates(): string
    {
        return implode(";",array_map(
            fn( Waypoint $w ) => $w->getOriginal()->getLongitude().",".$w->getOriginal()->getLatitude()
            ,$this->waypoints));
    }

    /**
     * @return array
     */
    public function getWaypoints(): array
    {
        return $this->waypoints;
    }

    /**
     * @param array $waypoints
     * @return $this
     */
    public function setWaypoints(array $waypoints): self
    {
        $this->waypoints = $waypoints;
        return $this;
    }





}