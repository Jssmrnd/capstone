<?php

namespace App\Filament\Fabricator\PageBlocks;

use Filament\Forms\Components\Builder\Block;
use Z3d0X\FilamentFabricator\PageBlocks\PageBlock;
use Filament\Forms;
use App\Models;
use App\Models\Unit;
use App\Models\UnitModel;

class ProductList extends PageBlock
{
    public static function getBlockSchema(): Block
    {
        return Block::make('product-list')
            ->schema([
                //set some texts here
            ]);
    }

    public static function mutateData(array $data): array
    {
        // dd(Unit::all()->first());
        $data["product_list"] = UnitModel::all();
        // dd(UnitModel::all()->first());
        return $data;
    }
}