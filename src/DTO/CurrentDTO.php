<?php

declare(strict_types=1);

namespace App\DTO;

class CurrentDTO
{
    public readonly int $lastUpdatedEpoch;
    public readonly string $lastUpdated;
    public readonly float $tempC;
    public readonly float $tempF;
    public readonly int $isDay;
    public readonly ConditionDTO $condition;
    public readonly float $windKph;
    public readonly int $windDegree;
    public readonly string $windDir;
    public readonly int $humidity;
    public readonly int $cloud;
    public readonly float $feelslikeC;
    public readonly ?AirQualityDTO $airQuality;

    public function __construct(array $data)
    {
        $this->lastUpdatedEpoch = $data['last_updated_epoch'];
        $this->lastUpdated = $data['last_updated'];
        $this->tempC = $data['temp_c'];
        $this->tempF = $data['temp_f'];
        $this->isDay = $data['is_day'];
        $this->condition = new ConditionDTO($data['condition']);
        $this->windKph = $data['wind_kph'];
        $this->windDegree = $data['wind_degree'];
        $this->windDir = $data['wind_dir'];
        $this->humidity = $data['humidity'];
        $this->cloud = $data['cloud'];
        $this->feelslikeC = $data['feelslike_c'];
        $this->airQuality = \array_key_exists('air_quality', $data) ? new AirQualityDTO($data['air_quality']) : null;
    }
}
