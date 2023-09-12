<?php

namespace App\Filament\Fabricator\PageBlocks;

use Filament\Forms\Components\Builder\Block;
use Z3d0X\FilamentFabricator\PageBlocks\PageBlock;
use Filament\Forms;
use App\Models;
use App\Models\Unit;

class ProductList extends PageBlock
{
    public static function getBlockSchema(): Block
    {
        return Block::make('product-list')
            ->schema([
                //
            ]);
    }


    public static function mutateData(array $data): array
    {
        $data["product_list"] = Unit::all();
        return $data;
    }
}