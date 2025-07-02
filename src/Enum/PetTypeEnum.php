<?php

namespace App\Enum;

enum PetTypeEnum: string
{
    case CAT = 'Cat';
    case DOG = 'Dog';

    public function getLabel(): string
    {
        return match ($this) {
            self::CAT => 'Cat',
            self::DOG => 'Dog',
        };
    }
}
