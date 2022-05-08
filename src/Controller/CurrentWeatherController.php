<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\WeatherService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CurrentWeatherController
{
    public function __construct(private readonly WeatherService $service)
    {
    }

    public function __invoke(Request $request): Response
    {
        if (null === $request->query->get('q')) {
            throw new BadRequestHttpException('"q" parameter is mandatory');
        }

        $data = $this->service->__invoke($request->query->get('q'), $request->query->get('aqi'));

        return new JsonResponse($data);
    }
}
