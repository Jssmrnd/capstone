<?php

namespace App\Filament\Resources\CustomerApplicationResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Infolists\Infolist;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Notifications;

class PaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'payments';
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Placeholder::make($this->getOwnerRecord()->applicant_surname),
                Forms\Components\Placeholder::make($this->getOwnerRecord()->applicant_lastname),

                Forms\Components\TextInput::make('payment_amount')
                        ->default(function (){
                            return $this->getOwnerRecord()->unit_amort_fin;
                        })
                        ->required()
                        ->maxLength(255),
                Forms\Components\Select::make('payment_status')
                        ->live()
                        ->options([
                            'advance' => 'Advance',
                            'current' => 'Current',
                            'overdue' => 'Overdue',
                            'diligent' => 'Diligent',
                        ])
                        ->required(),

                Forms\Components\TextInput::make('rebate_value')
                        ->disabled(fn (Forms\Get $get): bool => match($get('payment_status')){
                            'advance' => false,
                            'current' => false,
                            'advance' => true,
                            'current' => true,
                            default => true,
                        })
                        ->required(),
                
                Forms\Components\TextInput::make('payment_type')
                        ->required()
                        ->maxLength(255),
            ]);
    }


    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([  
                Tables\Columns\TextColumn::make('id')
                        ->label('Payment ID')
                        ->searchable(),                        
                Tables\Columns\TextColumn::make('created_at')
                        ->label('Date of payment'),
                Tables\Columns\TextColumn::make('payment_amount')
                        ->summarize(Sum::make())
                        ->money('php'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make()
                //         ->before(
                //                 //runs before the payment is save to the database.
                //                 function (Tables\Actions\CreateAction $action, Forms\Get $get, array $data) {
                //                         //calclate made payments
                //                         $get_record = $this->getOwnerRecord();
                //                         $unit_srp = $get_record->unit_srp;
                //                         $total_payments = $get_record->payments->sum('payment_amount');
                //                         $curr_payment_amount = $data['payment_amount'];

                //                         //checks if amount paid is same with unit's price.
                //                         if($total_payments+$curr_payment_amount == $unit_srp){
                //                             Notifications\Notification::make()
                //                             ->success()
                //                             ->persistent()
                //                             ->title("This account is now complete.")
                //                             ->body("account is now closed!")
                //                             ->send();
                //                             $get_record->application_status = "closed";
                //                             $get_record->save();
                //                         }

                //                         //checks if amount paid is less with the unit's price.
                //                         if($total_payments+$curr_payment_amount > $unit_srp){
                //                             Notifications\Notification::make()
                //                             ->warning()
                //                             ->persistent()
                //                             ->title("Failed to add a payment.")
                //                             ->body('Cannot add more payments to this account.')
                //                             ->send();
                //                             $action->halt();
                //                         }

                //                         //checks if the current customer application is approved.
                //                         if($get_record->application_status != "approved"){
                //                             Notifications\Notification::make()
                //                             ->warning()
                //                             ->persistent()
                //                             ->title("Cannot make payments")
                //                             ->body('Cannot make payments on applications')
                //                             ->send();
                //                             $action->halt();
                //                         }
                //                         else{

                //                         }
                //                 })
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                // Tables\Actions\CreateAction::make(),
            ]);
    }
}
