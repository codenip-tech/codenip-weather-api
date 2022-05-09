<?php

declare(strict_types=1);

namespace App\Controller;

use App\Http\DTO\Request\GetWeatherRequest;
use App\Service\WeatherService;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class CurrentWeatherController
{
    public function __construct(
        private readonly WeatherService $service,
        private readonly Environment $twig,
    ) {
    }

    public function index(): Response
    {
        $content = $this->twig->render('weather/index.html.twig', [
            'result' => null,
            'error' => null,
        ]);

        return new Response($content);
    }

    public function getWeather(GetWeatherRequest $request): Response
    {
        $data = $this->service->__invoke($request->q, $request->aqi);

        $content = $this->twig->render('weather/index.html.twig', [
            'result' => $data,
            'error' => null,
        ]);

        return new Response($content);
    }
}
