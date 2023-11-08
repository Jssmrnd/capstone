<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Models\CustomerApplication;
use App\Models\Unit;
use App\Models\Payment;
use Illuminate\Support\Facades\Blade;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;
use Filament\Notifications;
use Illuminate\Database\Eloquent\Model;

use App\Filament\Pages\TestPage;
use App\Filament\Resources\CustomerApplicationResource\Pages\ViewCustomerApplication;

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
                // Forms\Components\Select::make('current'),
                // Forms\Components\Select::make('overdue'),
                // Forms\Components\Select::make('delinquent'),
                // Forms\Components\Select::make('penalty'),
                // Forms\Components\Select::make('total'),
                // Forms\Components\Select::make('m_a'),
                // Forms\Components\Select::make('credit'),
                // Forms\Components\Select::make('penalty'),
                // Forms\Components\Select::make('customer_application_id'),

                Forms\Components\TextInput::make('due_date')
                        ->hidden(function(string $operation){
                            if($operation == "edit"){
                                return true;
                            }
                        }),
                Forms\Components\TextInput::make('payment_amount'),
                Forms\Components\TextInput::make('penalty'),
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
                            ->label('ID')
                            ->searchable(),
                    Tables\Columns\TextColumn::make('customerApplication.applicant_lastname')
                            ->label('First Name')
                            ->searchable(),
                    Tables\Columns\TextColumn::make('payment_amount')
                            ->label('Payment Amount')
                            ->money('php'),

                    Tables\Columns\TextColumn::make('created_at')
                            ->label('Date Paid')
                            ->dateTime('d-M-Y'),
            ])
            ->defaultSort('created_at', 'desc')

            ->defaultPaginationPageOption(5)
            ->filters([
                Tables\Filters\Filter::make('created_at')
            ])
            
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('pdf') 
                ->label('Print')
                ->color('success')
                ->action(function (Model $record) {
                    return response()->streamDownload(function () use ($record) {
                        echo Pdf::loadHtml(
                            Blade::render('monthly_amort_receipt', ['record' => $record, 'date_today' => Carbon::now()->format('d-M-Y')])
                        )->stream();
                    }, $record->id . '.pdf');
                }), 
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()->requiresConfirmation(),
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
            'view-customer-application' => ViewCustomerApplication::route('/{record}'),
        ];
    }
}
