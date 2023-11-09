<?php

namespace App\Filament\Resources;

use App\Models;
use App\Filament\Resources\UnitReleaseResource\Pages;
use App\Filament\Resources\UnitReleaseResource\RelationManagers;
use App\Models\CustomerApplication;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UnitReleaseResource extends Resource
{
    protected static ?string $model = CustomerApplication::class;

    protected static ?string $navigationLabel = 'Unit Release';
    
    protected static ?string $label = 'Release';

    protected static ?string $modelLabel = "Release";

    protected ?string $heading = 'Custom Page Heading';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function getUnitInofrmationComponent(): Forms\Components\Component
    {
        return Forms\Components\Group::make([
            Forms\Components\Fieldset::make('Unit Information')
                    ->schema([
                            Forms\Components\Select::make('unit_model_id')
                                    ->hint("Ex. Mio soul i")
                                    ->label('Unit Model')
                                    ->disabled()
                                    ->relationship(
                                            'unitModel',
                                            'model_name'
                                    )
                                    ->searchable(['model_name', 'id'])
                                    ->preload()
                                    ->live(),
                            Forms\Components\TextInput::make('unit_srp')
                                    ->disabled(),
                            Forms\Components\TextInput::make('unit_status')
                                    ->live(500)
                                    ->disabled(),
                            Forms\Components\Select::make('units_id')
                                    ->live()
                                    ->options(
                                            fn (Forms\Get $get): array => Models\Unit::where('customer_application_id', null)
                                                    ->where('unit_model_id', $get('unit_model_id'))         
                                                    ->limit(20)
                                                    ->pluck('chasis_number', 'id')
                                                    ->toArray()
                                    )
                                    ->afterStateUpdated(
                                        function(Forms\Get $get, Forms\Set $set)
                                        {
                                            if($get('units_id') != ""){
                                                $set('unit_status', Models\Unit::find($get('units_id'))->status);
                                            }
                                            else if($get('units_id') == ""){
                                                $set('unit_status', "");
                                            }
                                        }
                                    )
                                    ->prefix('#')
                                    ->label('Chasis Number')
                                    ->required(true)
                                    ->label('Chassis number'),
                    ]),
        ]);
    }

    public static function getReleaseDetailsComponent(): Forms\Components\Component
    {
        return Forms\Components\Group::make([
                Forms\Components\TextInput::make('unit_term')
                        ->columnSpan(1)
                        ->required(true)
                        ->label('Term:')
                        ->minValue(1)
                        ->numeric()
                        ->live(500)
                        ->afterStateUpdated(
                                function(Forms\Get $get, Forms\Set $set){
                                    $_term = $get('unit_term');
                                    $_unit_srp = $get('unit_srp');
                                    if($_term > 1){
                                            $quotient = number_format((float)$_unit_srp/$_term, 2, '.', '');
                                            $set('unit_amort_fin', $quotient);
                                            $set('unit_monthly_amort', $quotient);
                                    }
                                }
                        ),
                Forms\Components\Select::make('unit_type')
                        ->required()
                        ->options(['New','Repeat',]),
                Forms\Components\Select::make('unit_mode_of_payment')
                        ->required(true)
                        ->label('Mode of Payment:')
                        ->options(
                                ['Office','Field','Bank',]
                        )
                        ->columnSpan(1),
        ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                    UnitReleaseResource::getUnitInofrmationComponent()
                            ->columnSpan(2),
                    UnitReleaseResource::getReleaseDetailsComponent()
                            ->columns(3)
                            ->columnSpan(2),
                    Forms\Components\SpatieMediaLibraryFileUpload::make('media')
                            ->label('Stencil')
                            ->columnSpan(2),
                    
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->where('application_status', 'active'))
            ->columns([
                    Tables\Columns\TextColumn::make('id')
                            ->label("Application ID:")
                            ->searchable(),
                    Tables\Columns\TextColumn::make('application_type')
                            ->label("Type:")
                            ->badge()
                            ->searchable(),
                    Tables\Columns\TextColumn::make('application_status')
                            ->label("Status:")
                            ->badge(),
                    Tables\Columns\TextColumn::make('applicant_lastname')
                            ->label("Last Name:")
                            ->searchable(),
                    Tables\Columns\TextColumn::make('created_at')
                            ->label("Date Created:")
                            ->dateTime('d-M-Y'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                        ->label('Release'),
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
            'index' => Pages\ListUnitReleases::route('/'),
            // 'create' => Pages\CreateUnitRelease::route('/create'),
            'edit' => Pages\EditUnitRelease::route('/{record}/edit'),
        ];
    }    
}
