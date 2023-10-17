<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UnitModelResource\Pages;
use App\Filament\Resources\UnitModelResource\RelationManagers;
use App\Models\Unit;
use App\Models\UnitModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
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
                Forms\Components\TextInput::make('price')
                    ->maxLength(255),
                Forms\Components\TextInput::make('body_type')
                    ->maxLength(255),
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
                Tables\Columns\TextColumn::make('Stock')
                    ->getStateUsing( function (Model $record){
                        return Unit::where('unit_model_id', $record->id)
                                ->whereNull('customer_application_id')
                                ->count();
                    })
                    ->label('Unit Quantity')
                    ->searchable(),
                    // ->counts('unit')

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
                Tables\Actions\DeleteAction::make()
                    ->action(
                        function(Model $record){
                            if($record->getMedia('product-images')->first()){
                                $record->getMedia('product-images')->first()->delete();
                            }
                            $record->delete();
                        }),
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
