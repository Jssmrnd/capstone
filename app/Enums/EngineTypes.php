<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum EngineTypes:string implements HasLabel
{
    case FOUR_STROKE = "Four (4) Stroke";
    case TWO_STROKE = "Two (2) Stroke";
    case OTHERS = "Other(s)";

    public function getLabel(): ?string
    {
        return match ($this) {
            self::FOUR_STROKE => "Four (4) Stroke",
            self::TWO_STROKE => "Two (2) Stroke",
            self::OTHERS => "Other(s)",
        };
    }

	public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

}