<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum UnitTypes:string implements HasLabel
{
    case OFFROAD = "Offroad Bike";
    case UNDERBONE = "Underbone";
    case SCOOTER = "Scooter";
    case CRUISER = "Cruiser";
    case BUSINESSTYPE = "Business Type";
    case SPORTBIKES = "Sport Bikes";

    public function getLabel(): ?string
    {
        return match ($this) {
            self::OFFROAD => "Offroad Bike",
            self::UNDERBONE => "Underbone",
            self::SCOOTER => "Scooter",
            self::CRUISER => "Cruiser",
            self::BUSINESSTYPE => "Business Type",
            self::SPORTBIKES => "Sport Bikes",
        };
    }

	public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

}