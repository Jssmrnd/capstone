<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum TransmissionTypes:string implements HasLabel
{
    case MANUAL_4_SPEED = "Manual four (4) speed";
    case MANUAL_5_SPEED = "Manual five (5) speed";
    case MANUAL_6_SPEED = "Manual four (6) speed";
    case AUTOMATIC = "Automatic";

    public function getLabel(): ?string
    {
        return match ($this) {
            self::MANUAL_4_SPEED => "Manual four (4) speed",
            self::MANUAL_5_SPEED => "Manual five (5) speed",
            self::MANUAL_6_SPEED => "Manual four (6) speed",
            self::AUTOMATIC => "Automatic",
        };
    }

	public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

}