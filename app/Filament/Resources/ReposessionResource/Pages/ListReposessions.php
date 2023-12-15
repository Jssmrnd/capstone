<?php

namespace App\Filament\Resources\ReposessionResource\Pages;

use App\Filament\Resources\ReposessionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReposessions extends ListRecords
{
    protected static string $resource = ReposessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
