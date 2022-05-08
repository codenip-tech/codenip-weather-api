<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\CurrentWeatherDTO;
use App\Http\HttpClientInterface;

class WeatherService
{
    private const CURRENT_WEATHER_ENDPOINT = '/v1/current.json';

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly string $weatherApiKey
    ) {
    }

    public function __invoke(string $country, ?string $airQuality): CurrentWeatherDTO
    {
        $response = $this->httpClient->get(\sprintf(
            '%s?key=%s&q=%s&aqi=%s',
            self::CURRENT_WEATHER_ENDPOINT,
            $this->weatherApiKey,
            $country,
            $airQuality ?: 'no'
        ));

        $data = \json_decode($response->getBody()->getContents(), true);

        return new CurrentWeatherDTO($data);
    }
}
