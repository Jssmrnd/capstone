<?php

namespace App\Filament\Fabricator\PageBlocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Form;
use Z3d0X\FilamentFabricator\PageBlocks\PageBlock;

class CustomerApplicationForm extends PageBlock
{


    public static function getBlockSchema(): Block
    {
        return Block::make('customer-application-form')
            ->schema([
                
            ]);
    }

    public static function mutateData(array $data): array
    {
        return $data;
    }
}
