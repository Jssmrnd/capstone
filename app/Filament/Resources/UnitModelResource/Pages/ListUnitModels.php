<?php

namespace App\Filament\Resources\UnitModelResource\Pages;

use App\Filament\Resources\UnitModelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUnitModels extends ListRecords
{
    protected static string $resource = UnitModelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
