<?php

namespace App\Filament\Fabricator\PageBlocks;

use Filament\Forms\Components\Builder\Block;
use Z3d0X\FilamentFabricator\PageBlocks\PageBlock;
use Filament\Forms;

class CustomerTermsAndConditions extends PageBlock
{
    public static function getBlockSchema(): Block
    {
        return Block::make('customer-terms-and-conditions')
            ->schema([
                    Forms\Components\MarkdownEditor::make('register-terms-and-condition')
                            ->label('Terms for registration'),  
            ]);
    }

    public static function mutateData(array $data): array
    {
        return $data;
    }
}