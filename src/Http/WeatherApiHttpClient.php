<?php

declare(strict_types=1);

namespace App\Http;

use App\Exception\HttpClientException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WeatherApiHttpClient implements HttpClientInterface
{
    private Client $client;

    public function __construct(private readonly string $weatherApiBaseUrl)
    {
        $this->client = new Client([
            'base_uri' => $this->weatherApiBaseUrl,
        ]);
    }

    public function get(string $uri, array $options = []): ResponseInterface
    {
        try {
            return $this->client->request(Request::METHOD_GET, $uri, $options);
        } catch (ClientException|GuzzleException $e) {
            if ($e instanceof ClientException) {
                throw new HttpClientException($e->getResponse()->getStatusCode(), $e->getMessage());
            }

            throw new HttpClientException(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }
}
