<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum StartingSystemTypes:string implements HasLabel
{
    case KICK_AND_ELECTRIC = "Kick/Electric";
    case KICK = "Kick";
    case ELECTRIC = "Electric";

    public function getLabel(): ?string
    {
        return match ($this) {
            self::KICK_AND_ELECTRIC => "Kick/Electric",
            self::KICK => "Kick",
            self::ELECTRIC => "Electric",
        };
    }

	public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

}