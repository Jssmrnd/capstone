<?php

namespace App\Filament\Fabricator\PageBlocks;

use Filament\Forms\Components\Builder\Block;
use Z3d0X\FilamentFabricator\PageBlocks\PageBlock;
use Filament\Forms;

class Navigation extends PageBlock
{
    public static function getBlockSchema(): Block
    {
        return Block::make('navigation')
            ->schema([
                Forms\Components\TextInput::make('company_name'), 
            ]);
    }

    public static function mutateData(array $data): array
    {
        return $data;
    }
}