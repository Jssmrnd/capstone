<?php

namespace App\Filament\Resources\PermissionsResource\Pages;

use App\Filament\Resources\PermissionsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPermissions extends ListRecords
{
    protected static string $resource = PermissionsResource::class;

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
            'Users Module' => ListRecords\Tab::make()->query(fn ($query) => $query->where('name', 'like', '%' . "user" . '%')),
            'Permissions Module' => ListRecords\Tab::make()->query(fn ($query) => $query->where('name', 'like', '%' . "permissions" . '%')),
            'Roles Module' => ListRecords\Tab::make()->query(fn ($query) => $query->where('name', 'like', '%' . "roles" . '%')),
            'Application Module' => ListRecords\Tab::make()->query(fn ($query) => $query->where('name', 'like', '%' . "customer-application" . '%')),
            'Payments Module' => ListRecords\Tab::make()->query(fn ($query) => $query->where('name', 'like', '%' . "payment" . '%')),
            'Unit Module' => ListRecords\Tab::make()->query(fn ($query) => $query->where('name', 'like', '%' . "unit" . '%')),
        ];
    }

}
