<?php

namespace App\Filament\Resources\CustomerApplicationResource\Pages;

use App\Filament\Resources\CustomerApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateCustomerApplication extends CreateRecord
{
    protected static string $resource = CustomerApplicationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['branch_id'] = auth()->user()->branch_id;
        $data['application_is_new'] = false;
        $data['author_id'] = auth()->user()->id;
        $data['application_type'] = "walk-in";
        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        return static::getModel()::create($data);
    }

}