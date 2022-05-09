<?php

declare(strict_types=1);

namespace App\Http\DTO\Request;

use App\Http\DTO\RequestDTO;
use Symfony\Component\HttpFoundation\Request;

class GetWeatherRequest implements RequestDTO
{
    public readonly ?string $q;
    public readonly ?string $aqi;

    public function __construct(Request $request)
    {
        $this->q = $request->request->get('q');
        $this->aqi = $request->request->get('aqi');
    }
}
