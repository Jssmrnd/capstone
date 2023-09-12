<?php

namespace App\Filament\Fabricator\PageBlocks;

use Filament\Forms\Components\Builder\Block;
use Z3d0X\FilamentFabricator\PageBlocks\PageBlock;
use Filament\Forms;

class Hero extends PageBlock
{
    public static function getBlockSchema(): Block
    {
        return Block::make('hero')
            ->label('Hero')
            ->schema([
                Forms\Components\TextInput::make('heading_title'),
                Forms\Components\TextInput::make('heading_description'),
            ]);
    }

    public static function mutateData(array $data): array
    {
        return $data;
    }
}