<?php

namespace App\Filament\TestPanel\Resources\ProductsResource\Pages;

use App\Filament\TestPanel\Resources\ProductsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProducts extends CreateRecord
{
    protected static string $resource = ProductsResource::class;
}
