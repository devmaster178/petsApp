<?php

namespace App\Enum;
enum HasDobInformationEnum: string
{
    case YES = 'yes';
    case NO = 'no';

    public function getLabel(): string
    {
        return match($this) {
            self::YES => 'Yes',
            self::NO => 'No',
        };
    }
}
