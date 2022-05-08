<?php

declare(strict_types=1);

namespace App\DTO;

class AirQualityDTO
{
    public readonly float $co;
    public readonly float $no2;
    public readonly float $o3;
    public readonly float $so2;
    public readonly float $pm2_5;
    public readonly float $pm10;
    public readonly float $usEpaIndex;
    public readonly float $gbDefraIndex;

    public function __construct(array $data)
    {
        $this->co = $data['co'];
        $this->no2 = $data['no2'];
        $this->o3 = $data['o3'];
        $this->so2 = $data['so2'];
        $this->pm2_5 = $data['pm2_5'];
        $this->pm10 = $data['pm10'];
        $this->usEpaIndex = $data['us-epa-index'];
        $this->gbDefraIndex = $data['gb-defra-index'];
    }
}
