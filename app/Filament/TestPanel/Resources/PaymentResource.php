<?php

namespace App\Filament\TestPanel\Resources;

use App\Filament\TestPanel\Resources\PaymentResource\Pages;
use App\Models\CustomerApplication;
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
use App\Filament\Pages\Settings;

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
                titleAttribute: 'applicant_lastname',
                modifyQueryUsing: fn (Builder $query) => $query->where("application_status", "active"),
            )
            ->label('For Applicant:')
            ->preload()
            ->searchable()
            ->required()
            ->live()
            ->afterStateUpdated(
                function($state, Forms\Set $set){
                    $application = CustomerApplication::query()
                            ->where("id", $state)
                            ->first();

                    $due_date = $application->due_date;
                    $today = Carbon::parse(Carbon::today()->format('Y-m-d'));
                    $amort_fin = $application->unit_amort_fin;
                    $set('due_date', $due_date);
                    $set('payment_amount', $amort_fin);

                    //Y-m-d

                    $delinquent = Carbon::parse(Carbon::createFromFormat('Y-m-d', $due_date)->addDays(30));

                    $is_advance = $today->lessThan($due_date);
                    $is_current = $today->equalTo($due_date);
                    $is_overdue = $today->greaterThan($due_date) && $today->lessThan($delinquent);
                    $is_delinquent = $today->greaterThan($delinquent);

                    if($today->lessThan($due_date)){
                        $set('payment_status', 'advance');
                    }
                    elseif($today->equalTo($due_date)){
                        $set('payment_status', 'current');
                    }
                    elseif($today->greaterThan($due_date) && $today->lessThan($delinquent)){
                        $set('payment_status', 'overdue');
                    }
                    elseif($today->greaterThan($delinquent)){
                        $set('payment_status', 'delinquent');
                    }
                }
            ),
            Forms\Components\TextInput::make('due_date')
                    ->hidden(function(string $operation){
                        if($operation == "edit"){
                            return true;
                        }
                    }),
            Forms\Components\TextInput::make('payment_amount'),
            Forms\Components\Select::make('payment_status')
                    ->live()
                    ->options([
                        'advance' => 'Advance',
                        'current' => 'Current',
                        'overdue' => 'Overdue',
                        'diligent' => 'Diligent',
                    ])
                    ->required(),


            Forms\Components\Select::make('payment_type')->label('Payment Type:')
                    ->options([
                        "field" => "Field",
                        "office" => "Office",
                        "bank" => "Bank",
                    ])
                    ->columnSpan(1)
                    ->required(true),

            // Forms\Components\Actions::make([
            //             Forms\Components\Actions\Action::make("Online Payment")
            //             ->label("Checkout")
            //             ->action(function(){
            //                 return redirect()->route("paymongo", ["customerApplicationId" => 1]);
            //             }),
            //         ]),      
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                ->label('ID'),
                Tables\Columns\TextColumn::make('payment_amount')
                ->label('Payment Amount')
                ->money('php'),
                Tables\Columns\TextColumn::make('created_at')
                ->label('Date Paid')
                ->dateTime('d-M-Y'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            // 'create' => Pages\CreatePayment::route('/create'),
            'create' => Pages\CreatePaymongoCheckout::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }

}
