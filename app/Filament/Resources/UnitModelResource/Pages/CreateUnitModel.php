<?php

namespace App\Filament\Resources\UnitModelResource\Pages;

use App\Filament\Resources\UnitModelResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUnitModel extends CreateRecord
{
    protected static string $resource = UnitModelResource::class;

    protected function beforeCreate(){
    }

}
