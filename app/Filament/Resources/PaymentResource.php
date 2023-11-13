<?php

namespace App\Filament\Resources;

use App\Enums\ApplicationStatus;
use App\Enums\ReleaseStatus;
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


    public static function getDownpaymentInputComponent(): Forms\Components\Component
    {
        return Forms\Components\Group::make([
            Forms\Components\TextInput::make('payment_amount')
                    ->label('Down Payment'),
        ]);
    }

    public static function getPaymentDetails(): Forms\Components\Component
    {
        return Forms\Components\Group::make([

        ]);
    }

    public static function getPaymentInput(): Forms\Components\Component
    {
        return Forms\Components\Group::make([
            Forms\Components\TextInput::make('payment_amount')
                    ->label('Amount'),
        ]);
    }

    public static function getApplicationDetails(): Forms\Components\Component
    {
        return Forms\Components\Group::make([
                Forms\Components\Select::make('customer_application_id')
                ->relationship(
                        name: 'customerApplication',
                        titleAttribute: 'applicant_lastname',
                        modifyQueryUsing: fn (Builder $query) => $query->where("application_status", "Active")
                                                                                ->orwhere("application_status", "Approved"),
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
                        if($application != null){
                            if($application->application_status == ApplicationStatus::APPROVED_STATUS 
                                    && $application->release_status == ReleaseStatus::UN_RELEASED->value)
                            {
                                // dd("Down Payment");
                            }else if($application->application_status == ApplicationStatus::ACTIVE_STATUS){
                                // dd("Amort. Payment");
                            }
                        }
                        $due_date = $application->due_date;

                        $today = Carbon::parse(Carbon::today()->format(config('app.date_format')));
                        $amort_fin = $application->unit_monthly_amort;
                        $set('due_date', $due_date);
                        $set('payment_amount', $amort_fin);

                        $delinquent = Carbon::parse(Carbon::createFromFormat(config('app.date_format'), $due_date)->addDays(30));

                        $parsed_date = Carbon::parse(Carbon::createFromFormat(config('app.date_format'), $due_date));

                        $is_advance = $today->lessThan($parsed_date);
                        $is_current = $today->equalTo($parsed_date);
                        $is_overdue = $today->greaterThan($parsed_date) && $today->lessThan($delinquent);
                        $is_delinquent = $today->greaterThan($delinquent);

                        if($today->lessThan($parsed_date)){
                            $set('payment_status', 'advance');
                        }
                        elseif($today->equalTo($parsed_date)){
                            $set('payment_status', 'current');
                        }
                        elseif($today->greaterThan($parsed_date) && $today->lessThan($delinquent)){
                            $set('payment_status', 'overdue');
                        }
                        elseif($today->greaterThan($delinquent)){
                            $set('payment_status', 'delinquent');
                        }
                    }
                ),
        ]);
    }



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                PaymentResource::getApplicationDetails(),
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
