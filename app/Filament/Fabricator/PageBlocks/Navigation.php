<?php

namespace App\Filament\Fabricator\PageBlocks;

use App\Filament\CustomerPageModels\CustomerNavigationBar;
use Filament\Forms\Components\Builder\Block;
use Z3d0X\FilamentFabricator\PageBlocks\PageBlock;
use Filament\Forms;
use Z3d0X\FilamentFabricator\Models\Page;

class Navigation extends PageBlock
{
    public static function getBlockSchema(): Block
    {
        return Block::make('navigation')
            ->label('Top bar navigation')
            ->schema([
                //     Forms\Components\TextInput::make('company_name')
                //             ->label('Company/brand name'),


                //     Forms\Components\Section::make('login')
                //             ->description('')
                //             ->schema([
                //                         Forms\Components\TextInput::make('login')
                //                                 ->label('Login button text')
                //                                 ->columnspan(2),
                //                         Forms\Components\Toggle::make('login_visible')
                //                                 ->label('is visible')
                //                                 ->inline(false)
                //                                 ->onIcon('heroicon-o-eye')
                //                                 ->offIcon('heroicon-o-eye-slash'),
                //                     ])->columns(3),
                //     Forms\Components\Section::make('register')
                //             ->description('')
                //             ->schema([
                //                     Forms\Components\TextInput::make('register')
                //                             ->label('Register button text')
                //                             ->columnspan(2),
                //                     Forms\Components\Toggle::make('register_visible')
                //                             ->label('is visible')
                //                             ->inline(false)
                //                             ->onIcon('heroicon-o-eye')
                //                             ->offIcon('heroicon-o-eye-slash'),
                //             ])->columns(3),
                //     Forms\Components\Repeater::make('links')
                //             ->label('Page links')
                //             ->schema([
                //                 Forms\Components\TextInput::make('name')
                //                         ->label("link name"),
                //                 Forms\Components\Select::make('link')
                //                         ->prefix('/')
                //                         ->options(function():array{
                //                             $pages = Page::all()->pluck('title', 'slug')->toArray();
                //                             return $pages;
                //                         })
                //             ])     
            ]);
    }


    public static function mutateData(array $data): array
    {
        $data['company_name'] = "Motorstar";
        return $data;
    }
}