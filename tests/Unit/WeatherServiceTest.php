<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\DTO\AirQualityDTO;
use App\DTO\CurrentDTO;
use App\DTO\CurrentWeatherDTO;
use App\DTO\LocationDTO;
use App\Http\HttpClientInterface;
use App\Service\WeatherService;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class WeatherServiceTest extends TestCase
{
    private const CURRENT_WEATHER_ENDPOINT = '/v1/current.json';

    private HttpClientInterface|MockObject $httpClient;
    private string $weatherApiKey = 'asd123';

    private WeatherService $service;

    public function setUp(): void
    {
        $this->httpClient = $this->getMockBuilder(HttpClientInterface::class)->getMock();
        $this->service = new WeatherService($this->httpClient, $this->weatherApiKey);
    }

    public function testGetWeatherWithoutAirQuality(): void
    {
        $payload = [
            'country' => 'Spain',
            'airQuality' => 'no'
        ];

        $this->httpClient
            ->expects($this->exactly(1))
            ->method('get')
            ->with(\sprintf(
                '%s?key=%s&q=%s&aqi=%s',
                self::CURRENT_WEATHER_ENDPOINT,
                $this->weatherApiKey,
                $payload['country'],
                $payload['airQuality']
            ))
            ->willReturn(new Response(200, [], \json_encode($this->getResponseWithoutAirQuality())));

        $response = $this->service->__invoke($payload['country'], $payload['airQuality']);

        self::assertInstanceOf(CurrentWeatherDTO::class, $response);
        self::assertInstanceOf(LocationDTO::class, $response->location);
        self::assertInstanceOf(CurrentDTO::class, $response->current);
        self::assertNull($response->current->airQuality);
    }

    public function testGetWeatherWithAirQuality(): void
    {
        $payload = [
            'country' => 'Spain',
            'airQuality' => 'yes'
        ];

        $this->httpClient
            ->expects($this->exactly(1))
            ->method('get')
            ->with(\sprintf(
                '%s?key=%s&q=%s&aqi=%s',
                self::CURRENT_WEATHER_ENDPOINT,
                $this->weatherApiKey,
                $payload['country'],
                $payload['airQuality']
            ))
            ->willReturn(new Response(200, [], \json_encode($this->getResponseWithAirQuality())));

        $response = $this->service->__invoke($payload['country'], $payload['airQuality']);

        self::assertInstanceOf(CurrentWeatherDTO::class, $response);
        self::assertInstanceOf(LocationDTO::class, $response->location);
        self::assertInstanceOf(CurrentDTO::class, $response->current);
        self::assertInstanceOf(AirQualityDTO::class, $response->current->airQuality);
    }

    private function getResponseWithoutAirQuality(): array
    {
        return [
            'location' => [
                'name' => 'Madrid',
                'region' => 'Madrid',
                'country' => 'Spain',
                'lat' => 40.4,
                'lon' => -3.68,
                'tz_id' => 'Europe/Madrid',
                'localtime_epoch' => 1652083756,
                'localtime' => '2022-05-09 10:09'
            ],
            'current' => [
                'last_updated_epoch' => 1652079600,
                'last_updated' => '2022-05-09 09:00',
                'temp_c' => 17,
                'temp_f' => 62.6,
                'is_day' => 1,
                'condition' => [
                    'text' => 'Sunny',
                    'icon' => '//cdn.weatherapi.com/weather/64x64/day/113.png',
                    'code' => 1000
                ],
                'wind_mph' => 3.8,
                'wind_kph' => 6.1,
                'wind_degree' => 100,
                'wind_dir' => 'E',
                'pressure_mb' => 1022,
                'pressure_in' => 30.18,
                'precip_mm' => 0,
                'precip_in' => 0,
                'humidity' => 55,
                'cloud' => 0,
                'feelslike_c' => 17,
                'feelslike_f' => 62.6,
                'vis_km' => 10,
                'vis_miles' => 6,
                'uv' => 5,
                'gust_mph' => 6.5,
                'gust_kph' => 10.4
            ]
        ];
    }

    private function getResponseWithAirQuality(): array
    {
        return [
            'location' => [
                'name' => 'Madrid',
                'region' => 'Madrid',
                'country' => 'Spain',
                'lat' => 40.4,
                'lon' => -3.68,
                'tz_id' => 'Europe/Madrid',
                'localtime_epoch' => 1652083756,
                'localtime' => '2022-05-09 10:09'
            ],
            'current' => [
                'last_updated_epoch' => 1652079600,
                'last_updated' => '2022-05-09 09:00',
                'temp_c' => 17,
                'temp_f' => 62.6,
                'is_day' => 1,
                'condition' => [
                    'text' => 'Sunny',
                    'icon' => '//cdn.weatherapi.com/weather/64x64/day/113.png',
                    'code' => 1000
                ],
                'wind_mph' => 3.8,
                'wind_kph' => 6.1,
                'wind_degree' => 100,
                'wind_dir' => 'E',
                'pressure_mb' => 1022,
                'pressure_in' => 30.18,
                'precip_mm' => 0,
                'precip_in' => 0,
                'humidity' => 55,
                'cloud' => 0,
                'feelslike_c' => 17,
                'feelslike_f' => 62.6,
                'vis_km' => 10,
                'vis_miles' => 6,
                'uv' => 5,
                'gust_mph' => 6.5,
                'gust_kph' => 10.4,
                'air_quality' => [
                    'co' => 390.5,
                    'no2' => 22.60000038147,
                    'o3' => 21.60000038147,
                    'so2' => 0.69999998807907,
                    'pm2_5' => 5.8000001907349,
                    'pm10' => 7.6999998092651,
                    'us-epa-index' => 1,
                    'gb-defra-index' => 1
                ]
            ]
        ];
    }
}