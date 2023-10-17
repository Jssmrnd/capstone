<?php

namespace App\Filament\Resources\UnitModelResource\Pages;

use App\Filament\Resources\UnitModelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\DB;

class EditUnitModel extends EditRecord
{
    protected static string $resource = UnitModelResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
