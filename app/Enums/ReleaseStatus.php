<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ReleaseStatus:string implements HasLabel
{
    case RELEASED          = "released";
    case UN_RELEASED          = "un-released";

    public function getLabel(): ?string
    {
        return match ($this) {
            self::RELEASED => 'released',
            self::UN_RELEASED => 'un-released',
        };
    }
}