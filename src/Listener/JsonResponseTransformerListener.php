<?php

declare(strict_types=1);

namespace App\Listener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;

class JsonResponseTransformerListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $e = $event->getThrowable();

        $data = [
            'class' => \get_class($e),
            'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
            'message' => $e->getMessage(),
        ];

        if ($e instanceof HttpException) {
            $data['code'] = $e->getStatusCode();
        }

        $event->setResponse($this->prepareResponse($data));
    }

    private function prepareResponse(array $data): Response
    {
        return new JsonResponse($data, $data['code']);
    }
}
