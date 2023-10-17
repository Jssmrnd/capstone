<?php

namespace App\Filament\TestPanel\Resources;

use App\Filament\TestPanel\Resources\PaymentResource\Pages;
use App\Filament\TestPanel\Resources\PaymentResource\RelationManagers;
use App\Models\Payment;
use App\Models;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('customer_application_id')
                ->relationship(
                    name: 'customerApplication',
                    titleAttribute: 'id',
                    modifyQueryUsing: fn (Builder $query) => $query->where([
                        ["author_id", auth()->user()->id],
                        ["application_status", "active"],
                    ]
                    ),
                )
                ->label('For Applicant:')
                ->preload()
                ->searchable()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }    
}
