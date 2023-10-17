<?php

namespace App\Filament\TestPanel\Resources\CustomerApplicationResource\Pages;

use App\Filament\TestPanel\Resources\CustomerApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomerApplication extends CreateRecord
{
    protected static string $resource = CustomerApplicationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // set mutations.
        $data['application_is_new'] = false;
        $data['author_id'] = auth()->user()->id;
        $data['application_type'] = "online";
        return $data;
    }
}
