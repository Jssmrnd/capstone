<?php

namespace App\Filament\Resources\CustomerApplicationResource\Pages;

use App\Filament\Resources\CustomerApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomerApplication extends CreateRecord
{
    protected static string $resource = CustomerApplicationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['application_is_new'] = false;
    
        return $data;
    }

}
