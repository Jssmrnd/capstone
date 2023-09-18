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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;
use Filament\Notifications;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('customer_application_id')
                ->relationship(
                    name: 'customerApplication',
                    titleAttribute: 'applicant_lastname',
                    modifyQueryUsing: fn (Builder $query) => $query->where("application_status", "approved"),
                )
                ->label('For Applicant:')
                ->preload()
                ->searchable()
                ->required()
                ->live()
                ->afterStateUpdated(
                    function($state, Forms\Set $set){
                        $application = CustomerApplication::query()->where("id", $state)->first();
                        $due_date = $application->due_date;
                        $amort_fin = $application->unit_amort_fin;
                        $set('due', $due_date);
                        $set('payment_amount', $amort_fin);

                        $due = Carbon::parse(Carbon::createFromFormat('Y-m-d', $due_date));
                        $delinquent = Carbon::parse(Carbon::createFromFormat('Y-m-d', $due_date)->addDays(30));
                        $today = Carbon::parse(Carbon::today()->format('Y-m-d'));

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
                Forms\Components\TextInput::make('due'),
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
                Tables\Actions\EditAction::make()
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
