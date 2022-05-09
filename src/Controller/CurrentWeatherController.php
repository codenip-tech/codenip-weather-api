<?php

declare(strict_types=1);

namespace App\Controller;

use App\Http\DTO\Request\GetWeatherRequest;
use App\Service\WeatherService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CurrentWeatherController
{
    public function __construct(private readonly WeatherService $service)
    {
    }

    public function __invoke(GetWeatherRequest $request): Response
    {
        $data = $this->service->__invoke($request->q, $request->aqi);

        return new JsonResponse($data);
    }
}
