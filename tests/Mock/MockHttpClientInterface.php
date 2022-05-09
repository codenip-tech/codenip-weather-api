<?php

declare(strict_types=1);

namespace App\Tests\Mock;

use Psr\Http\Message\ResponseInterface;

interface MockHttpClientInterface
{
    public function addResponse(string $uri, ResponseInterface $response): self;

    public function addException(\Exception $exception): self;
}