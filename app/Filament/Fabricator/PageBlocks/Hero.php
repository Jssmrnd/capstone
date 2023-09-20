<?php

namespace App\Filament\Fabricator\PageBlocks;

use Filament\Forms\Components\Builder\Block;
use Z3d0X\FilamentFabricator\PageBlocks\PageBlock;
use Filament\Forms;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class Hero extends PageBlock
{
    public static function getBlockSchema(): Block
    {
        return Block::make('hero')
            ->label('Hero')
            ->schema([
                
                Forms\Components\TextInput::make('heading_title')
                        ->label("Heading Text"),
                
                Forms\Components\Select::make('image_for')
                        ->required()
                        ->options([
                            'homepage-hero-image' => "Home Page",
                            'aboutpage-hero-image' => "About Page",
                            'applicationpage-hero-image' => "Application Page",
                            'productpage-hero-image' => "Product Page",
                        ]),

                Forms\Components\FileUpload::make("heading_image")
                        ->required()
                        ->label("Heading Image")
                        ->disk('local')
                        ->directory('public/site-images')
                        ->visibility('private')
                        ->acceptedFileTypes(['image/jpeg'])
                        ->getUploadedFileNameForStorageUsing(
                            fn (Forms\Get $get, TemporaryUploadedFile $file): string => (string) $get('image_for').".jpg"
                        ),
            ]);
    }

    public static function mutateData(array $data): array
    {
        return $data;
    }
}