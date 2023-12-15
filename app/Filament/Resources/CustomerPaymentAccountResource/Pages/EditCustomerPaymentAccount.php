<?php

namespace App\Filament\Resources\CustomerPaymentAccountResource\Pages;

use App\Filament\Resources\CustomerPaymentAccountResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomerPaymentAccount extends EditRecord
{
    protected static string $resource = CustomerPaymentAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
