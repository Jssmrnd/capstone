<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ApplicationStatus:string implements HasLabel
{
    case PENDING_STATUS          = "pending";
    case ACTIVE_STATUS          = "active";
    case REJECTED_STATUS        = "reject";
    case CLOSED_STATUS          = "closed";
    case RESUBMISSION_STATUS    = "resubmission";

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PENDING_STATUS => 'pending',
            self::ACTIVE_STATUS => 'active',
            self::REJECTED_STATUS => 'rejected',
            self::RESUBMISSION_STATUS => 'resubmission',
        };
    }
}