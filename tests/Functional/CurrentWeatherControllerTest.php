<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Tests\Mock\MockHttpClient;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class CurrentWeatherControllerTest extends WebTestCase
{
    private const GET_WEATHER_ENDPOINT = '/weather';
    private const WEATHER_API_ENDPOINT = '/v1/current.json';

    /**
     * @dataProvider weatherDataProvider
     */
    public function testGetWeather(array $payload, string $key, array $responseData): void
    {
        $client = static::createClient();
        $client->getContainer()->get(MockHttpClient::class)
            ->addResponse(
                \sprintf(
                    '%s?key=%s&q=%s&aqi=%s',
                    self::WEATHER_API_ENDPOINT,
                    $key,
                    $payload['q'],
                    $payload['aqi']
                ),
                new \GuzzleHttp\Psr7\Response(
                    Response::HTTP_OK,
                    [],
                    \json_encode($responseData)
                )
            );

        $client->request(Request::METHOD_POST, self::GET_WEATHER_ENDPOINT, $payload);

        $response = $client->getResponse();

        self::assertInstanceOf(Response::class, $response);
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testGetWeatherWithoutApiKey(): void
    {
        $client = static::createClient();
        $client->getContainer()->get(MockHttpClient::class)
            ->addException(new UnauthorizedHttpException('Invalid API Key'));

        $client->request(Request::METHOD_POST, self::GET_WEATHER_ENDPOINT, ['q' => 'Spain', 'aqi' => 'yes']);

        $response = $client->getResponse();

        self::assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    public function weatherDataProvider(): iterable
    {
        yield 'GET response with air quality' => [
            'payload' => [
                'q' => 'Spain',
                'aqi' => 'yes',
            ],
            'key' => 'asdasd1234234',
            'responseData' => [
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
            ]
        ];

        yield 'GET response without air quality' => [
            'payload' => [
                'q' => 'Spain',
                'aqi' => 'no',
            ],
            'key' => 'asdasd1234234',
            'responseData' => [
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
                ]
            ]
        ];
    }
}