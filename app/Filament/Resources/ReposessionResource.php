<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReposessionResource\Pages;
use App\Filament\Resources\ReposessionResource\RelationManagers;
use App\Models\Reposession;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReposessionResource extends Resource
{
    protected static ?string $model = Reposession::class;

    protected static ?string $navigationGroup = 'Reposession Module';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Fieldset::make('Address')
                    ->columns(3)
                    ->schema([

                        Forms\Components\TextInput::make('name')
                            ->label("Reports."),

                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("id")
                    ->wrap()
                    ->label("ID"),
                Tables\Columns\TextColumn::make("name")
                    ->label("Name"),
                Tables\Columns\TextColumn::make("created_at")
                    ->label("Date Created")
                    ->dateTime('d-M-Y'),
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
            'index' => Pages\ListReposessions::route('/'),
            'create' => Pages\CreateReposession::route('/create'),
            'edit' => Pages\EditReposession::route('/{record}/edit'),
        ];
    }
}
