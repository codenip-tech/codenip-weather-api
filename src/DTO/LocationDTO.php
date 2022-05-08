<?php

declare(strict_types=1);

namespace App\DTO;

class LocationDTO
{
    public readonly string $name;
    public readonly string $region;
    public readonly string $country;
    public readonly float $lat;
    public readonly float $lon;
    public readonly string $timeZone;
    public readonly int $localTimeEpoch;
    public readonly string $localTime;

    public function __construct(array $data)
    {
        $this->name = $data['name'];
        $this->region = $data['region'];
        $this->country = $data['country'];
        $this->lat = $data['lat'];
        $this->lon = $data['lon'];
        $this->timeZone = $data['tz_id'];
        $this->localTimeEpoch = $data['localtime_epoch'];
        $this->localTime = $data['name'];
    }
}
