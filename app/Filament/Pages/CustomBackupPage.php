<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use ShuvroRoy\FilamentSpatieLaravelBackup\Pages\Backups as BaseBackups;

class CustomBackupPage extends BaseBackups
{
    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';

    public function getHeading(): string | Htmlable
    {
        return 'Database Backups';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Utilities';
    }
}
