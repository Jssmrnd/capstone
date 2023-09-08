<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Models\CustomerApplication;
use App\Models\Unit;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('payment_type')->label('Payment Type:')
                        ->columnSpan(1)
                        ->required(true),
                Forms\Components\Select::make('customer_application_id')
                        ->label('Application ID:')
                        ->relationship('customerApplication', 'id')
                        ->preload()
                        ->searchable()
                        ->required()
                        ->live(),
                Forms\Components\Select::make('payment_amount')
                        ->relationship('customerApplication', 'unit_monthly_amort')
                        ->label('Payment Amount:')
                        ->columnSpan(1)
                        ->required(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                        ->label('ID'),

                Tables\Columns\TextColumn::make('customerApplication.applicant_lastname')
                        ->label('First Name'),

                Tables\Columns\TextColumn::make('payment_amount')
                        ->label('Payment Amount')
                        ->money('php'),

                Tables\Columns\TextColumn::make('created_at')
                        ->label('Date Paid')
                        ->dateTime('d-M-Y'),
            ])
            ->filters([
                Tables\Filters\Filter::make('created_at')
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
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }    
}
