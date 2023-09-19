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
                Forms\Components\TextInput::make('heading_title')
                        ->label("Heading Text"),
                Forms\Components\FileUpload::make("heading_image")
                        ->label("Heading Image")
                        ->disk('local')
                        ->directory('page-images')
                        ->visibility('private'),
                
            ]);
    }

    public static function mutateData(array $data): array
    {
        return $data;
    }
}