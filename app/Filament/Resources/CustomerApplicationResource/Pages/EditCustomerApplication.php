<?php

namespace App\Filament\Resources\CustomerApplicationResource\Pages;

use App\Filament\Resources\CustomerApplicationResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditCustomerApplication extends EditRecord
{
    protected static string $resource = CustomerApplicationResource::class;



    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['application_is_new'] = false;
        //$data['units_id'] = ;
        return $data;
    }

}
