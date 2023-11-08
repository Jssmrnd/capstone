<?php

namespace App\Filament\Resources\UnitReleaseResource\Pages;

use App\Filament\Resources\UnitReleaseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUnitReleases extends ListRecords
{
    protected static string $resource = UnitReleaseResource::class;

    

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
