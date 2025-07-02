<?php

namespace App\Enum;

enum BreedChoiceEnum: string
{
    case UNKNOWN = 'unknown';
    case MIX = 'mix';

    public function getLabel(): string
    {
        return match ($this) {
            self::UNKNOWN => "I don't know",
            self::MIX => "It's a mix",
        };
    }
}
