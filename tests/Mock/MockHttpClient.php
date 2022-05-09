<?php

declare(strict_types=1);

namespace App\Tests\Mock;

use App\Http\HttpClientInterface;
use Psr\Http\Message\ResponseInterface;

class MockHttpClient implements HttpClientInterface, MockHttpClientInterface
{
    private array $responses = [];
    private ?\Exception $exception = null;

    public function get(string $uri, array $options = []): ResponseInterface
    {
        if (\array_key_exists($uri, $this->responses)) {
            return $this->responses[$uri];
        }

        throw $this->exception;
    }

    public function addResponse(string $uri, ResponseInterface $response): self
    {
        $this->responses[$uri] = $response;

        return $this;
    }

    public function addException(\Exception $exception): self
    {
        $this->exception = $exception;

        return $this;
    }
}