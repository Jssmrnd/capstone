<?php

namespace App\Filament\TestPanel\Resources\ProductsResource\Pages;

use App\Filament\TestPanel\Resources\ProductsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProducts extends EditRecord
{
    protected static string $resource = ProductsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
