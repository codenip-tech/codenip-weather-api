<?php

declare(strict_types=1);

namespace App\Listener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Twig\Environment;

class ExceptionResponseTransformerListener
{
    public function __construct(private readonly Environment $twig)
    {
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $e = $event->getThrowable();

        $content = $this->twig->render('weather/index.html.twig', [
            'result' => null,
            'error' => $e->getMessage(),
        ]);

        $event->setResponse(new Response($content));
    }
}
