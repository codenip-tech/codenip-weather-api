<?php

declare(strict_types=1);

namespace App\DTO;

class CurrentWeatherDTO
{
    public readonly LocationDTO $location;
    public readonly CurrentDTO $current;

    public function __construct(array $data)
    {
        $this->location = new LocationDTO($data['location']);
        $this->current = new CurrentDTO($data['current']);
    }
}
