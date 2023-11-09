<?php

namespace App\Filament\Resources\CustomerApplicationResource\Pages;

use App\Filament\Resources\CustomerApplicationResource;
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

    public function getTabs(): array
    {
        return [
            null => ListRecords\Tab::make('Recents'),
            'pending' => ListRecords\Tab::make()->query(fn ($query) => $query->where('application_status', 'pending')),
            'approved' => ListRecords\Tab::make()->query(fn ($query) => $query->where('application_status', 'active')),
            'rejected' => ListRecords\Tab::make()->query(fn ($query) => $query->where('application_status', 'reject')),
        ];
    }

}
