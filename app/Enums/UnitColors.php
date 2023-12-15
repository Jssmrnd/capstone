<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum UnitColors:string implements HasLabel
{
    case BLK = "Black";
    case WHT = "White";
    case RED = "Red";
    case BLU = "Blue";
    case YLW = "Yellow";
    case ORG = "Orange";
    case GRY = "Grey";
    case GRN = "Green";
    case BRN = "Brown";
    case OTHER = "Other";

    public function getLabel(): ?string
    {
        return match ($this) {
            self::BLK => "Black",
            self::WHT => "White",
            self::RED => "Red",
            self::BLU => "Blue",
            self::YLW => "Yellow",
            self::ORG => "Orange",
            self::GRY => "Grey",
            self::GRN => "Green",
            self::BRN => "Brown",
            self::OTHER => "Other",
        };
    }

	public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

}