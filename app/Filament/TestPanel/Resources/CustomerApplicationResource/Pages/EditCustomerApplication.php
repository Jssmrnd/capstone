<?php

namespace App\Filament\TestPanel\Resources\CustomerApplicationResource\Pages;

use App\Filament\TestPanel\Resources\CustomerApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomerApplication extends EditRecord
{
    protected static string $resource = CustomerApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
