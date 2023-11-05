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
            ->label('Hero section')
            ->schema([
                
                Forms\Components\TextInput::make('heading_title')
                        ->label("Heading Text"),
                
                Forms\Components\Select::make('image_for')
                        ->required()
                        ->options([
                            'homepage-hero-image' => "home page",
                            'aboutpage-hero-image' => "about us page",
                            'applicationpage-hero-image' => "application page",
                            'productpage-hero-image' => "products page",
                            'contactpage-hero-image' => "contact us page",
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
        $data['heading_image'] = pathinfo($data['heading_image'], PATHINFO_FILENAME).".".pathinfo($data['heading_image'], PATHINFO_EXTENSION);;
        // dd($data['heading_image']);
        return $data;
    }
}