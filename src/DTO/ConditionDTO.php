<?php

declare(strict_types=1);

namespace App\DTO;

class ConditionDTO
{
    public readonly string $text;
    public readonly string $icon;
    public readonly int $code;

    public function __construct(array $data)
    {
        $this->text = $data['text'];
        $this->icon = $data['icon'];
        $this->code = $data['code'];
    }
}
