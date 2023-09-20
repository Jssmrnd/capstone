<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UnitModelResource\Pages;
use App\Filament\Resources\UnitModelResource\RelationManagers;
use App\Models\UnitModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UnitModelResource extends Resource
{
    protected static ?string $model = UnitModel::class;

    protected static ?string $navigationGroup = 'Inventory Module';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('model_name')
                    ->maxLength(255),
                Forms\Components\SpatieMediaLibraryFileUpload::make('media')
                    ->collection('product-images')
                    ->required(),
                Forms\Components\Textarea::make('colors')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('price')
                    ->maxLength(255),
                Forms\Components\TextInput::make('body_type')
                    ->maxLength(255),
                Forms\Components\TextInput::make('dry_weight')
                    ->numeric(),
                Forms\Components\TextInput::make('length_mm')
                    ->numeric(),
                Forms\Components\TextInput::make('width_mm')
                    ->numeric(),
                Forms\Components\TextInput::make('height_mm')
                    ->numeric(),
                Forms\Components\TextInput::make('wheelbase_mm')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('product_image')
                    ->collection('product-images'),
                Tables\Columns\TextColumn::make('model_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('php')
                    ->searchable(),
                Tables\Columns\TextColumn::make('body_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('unit.unit_quantity')
                    ->label('Unit Quantity')
                    ->searchable(),
                // Tables\Columns\TextColumn::make('dry_weight')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('length_mm')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('width_mm')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('height_mm')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('wheelbase_mm')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUnitModels::route('/'),
            'create' => Pages\CreateUnitModel::route('/create'),
            'edit' => Pages\EditUnitModel::route('/{record}/edit'),
        ];
    }    
}
