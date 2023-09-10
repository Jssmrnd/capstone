<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UnitResource\Pages;
use App\Filament\Resources\UnitResource\RelationManagers;
use App\Filament\Resources\UnitResource\RelationManagers\IncomingUnitRelationManager;
use App\Filament\Resources\UnitResource\RelationManagers\OutgoingUnitRelationManager;
use App\Models\OutgoingUnit;
use App\Models\Unit;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UnitResource extends Resource
{
    protected static ?string $model = Unit::class;

    protected static ?string $navigationGroup = 'Inventory Module';
    
    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('unit_model')
                        ->label('Model')
                        ->required(),
                TextInput::make('unit_color')
                        ->label('Color'),
                TextInput::make('unit_type')
                        ->label('Type')
                        ->required(),
                TextInput::make('unit_quantity')
                        ->label('Quantity')
                        ->numeric()
                        ->rules(['integer', 'min:0'])
                        ->required(),
                TextInput::make('unit_srp')
                        ->label('Selling Retail Price')
                        ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('unit_model')->label('Model'),
                TextColumn::make('unit_srp')->label('Price')->money('php'),
                TextColumn::make('unit_quantity')->label('Quantity'),
                TextColumn::make('unit_model')->searchable(['unit_model', 'unit_price', 'unit_type']),
            ])
            ->filters([
                Tables\Filters\Filter::make('branch_filter')
                    ->default()
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->where('unit_branch', auth()->user()->branch_id);
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([

            ]);
    }
    
    public static function getRelations(): array
    {
        return [
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUnits::route('/'),
            'create' => Pages\CreateUnit::route('/create'),
            'edit' => Pages\EditUnit::route('/{record}/edit'),
        ];
    }    
}
