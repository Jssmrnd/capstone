<?php

namespace App\Filament\Resources\UnitResource\Pages;

use App\Filament\Resources\UnitResource;
use App\Models\Unit;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateUnit extends CreateRecord
{
    protected static string $resource = UnitResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['unit_branch'] = auth()->user()->branch_id;
    
        return $data;
    }

}
