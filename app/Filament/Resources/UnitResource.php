<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UnitResource\Pages;
use App\Models\Branch;
use App\Models\Unit;
use Filament\Forms;
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

    public static function getUnitStockDetailsComponent(): Forms\Components\Component
    {
        return Forms\Components\Group::make([
            Forms\Components\Select::make('unit_model_id')
                    ->relationship('unitModel', 'model_name')
                    ->columnSpan(1)
                    ->required(),
            Forms\Components\Select::make('status')
                    ->columnSpan(1)
                    ->options([
                            'brand-new' => 'New',
                            'depo' => 'Depo',
                            'repo' => 'Repo',
                    ])
                    ->required(),
            Forms\Components\TextInput::make('chasis_number')
                    ->numeric()
                    ->columnSpan(1)
                    ->required(),
            Forms\Components\TextInput::make('engine_number')
                    ->columnSpan(1)
                    ->numeric()
                    ->required(),
            Forms\Components\Textarea::make('notes')
                    ->columnSpan(2),      
        ])
        ->columns(2);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                UnitResource::getUnitStockDetailsComponent()->columnSpan(2),
                Forms\Components\Fieldset::make('Branch Details')
                        ->schema([
                            Forms\Components\Placeholder::make('branch')
                            ->columnSpan(2)
                            ->label('Current Branch')
                            ->content(fn ():string => Branch::query()
                                                        ->where('id', auth()->user()->branch_id)->first()->full_address)
                        ])
                        ->columnSpan(1),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('Id'),
                TextColumn::make('unitModel.model_name')->label('Model'),
                TextColumn::make('status')->label('status'),
                TextColumn::make('unitModel.price')->label('Price')->money('php'),
                TextColumn::make('chasis_number'),
                TextColumn::make('created_at'),
            ])
            ->filters([
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
