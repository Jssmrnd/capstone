<?php

namespace App\Filament\TestPanel\Resources\CustomerApplicationResource\Pages;

use App\Filament\TestPanel\Resources\CustomerApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCustomerApplications extends ListRecords
{
    protected static string $resource = CustomerApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
