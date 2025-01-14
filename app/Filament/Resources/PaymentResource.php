<?php

namespace App\Filament\Resources;

use App\Enums\ApplicationStatus;
use App\Enums\ReleaseStatus;
use App\Filament\Resources\PaymentResource\Pages;
use App\Models\CustomerApplication;
use App\Models\Unit;
use App\Models\CustomerPaymentAccount;
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

    public static function getApplicationInformation(): Forms\Components\Component
    {
        return Forms\Components\Group::make([
            Forms\Components\Section::make("Customer Application's Information")

                ->schema([
                    Forms\Components\TextInput::make('application_full_name')
                        ->columnSpan(3)
                        ->disabled()
                        ->label('Full name'),
                    Forms\Components\TextInput::make('application_unit')
                        ->columnSpan(6)
                        ->disabled()
                        ->label('Unit'),
                    Forms\Components\TextInput::make('application_balance')
                        ->columnSpan(6)
                        ->disabled()
                        ->label('Balance'),
                    Forms\Components\TextInput::make('est_monthly_payment')
                        ->columnSpan(6)
                        ->disabled()
                        ->label('Estimated monthly payment'),
                    Forms\Components\TextInput::make('application_unit_price')
                        ->columnSpan(6)
                        ->disabled()
                        ->label('Price'),
                ])
                ->columns(6)
        ]);
    }

    public static function getPaymentDetails(): Forms\Components\Component
    {
        return Forms\Components\Group::make([
            Forms\Components\Placeholder::make("Payment is")
                ->content(function (Forms\Get $get): string {
                    $dp = CustomerApplication::query()
                        ->where('id', $get('customer_application_id'))
                        ->first();
                    if ($dp != null) {
                        if ($dp->hasMonthlyPayment() == false) {
                            return "Down Payment";
                        }
                        return "Monthly Payment";
                    }
                    return "";
                })
                ->columnSpan(2),
            Forms\Components\TextInput::make('customer_application_id')
                ->columnSpan(2)
                ->readOnly()
                ->label('Application ID'),
            Forms\Components\TextInput::make('due_date')
                ->columnSpan(6)
                ->readOnly()
                ->hidden(function (string $operation) {
                    if ($operation == "edit") {
                        return true;
                    }
                }),
            Forms\Components\TextInput::make('payment_amount')
                ->live()
                ->columnSpan(2)
                ->required(),
            Forms\Components\Select::make('payment_status')
                ->live()
                ->options([
                    'advance' => 'Advance',
                    'current' => 'Current',
                    'overdue' => 'Overdue',
                    'diligent' => 'Diligent',
                ])
                ->columnSpan(2)
                ->required(),
            Forms\Components\TextInput::make('remaining')
                ->live()
                ->columnSpan(2)
                ->readonly(),
            Forms\Components\Select::make('payment_type')->label('Payment Type:')
                ->options([
                    "field" => "Field",
                    "office" => "Office",
                    "bank" => "Bank",
                ])
                ->columnSpan(6)
                ->required(true),
        ])
            ->columns(6);
    }

    public static function getApplicationDetails(): Forms\Components\Component
    {
        return Forms\Components\Group::make([
            Forms\Components\Select::make('account_id')
                ->searchable()
                ->columnSpan(1)
                ->getSearchResultsUsing(fn(string $search): array => CustomerPaymentAccount::where('id', $search)
                    ->get()->pluck("id", "customer_application_id")->toArray())
                ->getOptionLabelUsing(fn($value): ?string => CustomerPaymentAccount::find($value)->customer_application_id)
                ->required()
                ->live()
                ->afterStateUpdated(
                    function ($state, Forms\Set $set) {
                        $application = CustomerPaymentAccount::query()->where("customer_application_id", $state)->first();
                        $cust_app = CustomerApplication::where("id", $state)->first();
                        // $payment_amount = 0;
                        // if ($application->monthly_payment == false) //initial payment (Down payment)
                        // {
                        //     $payment_amount = $application->unit_ttl_dp;
                        // } else if ($application->monthly_payment == true) //on going payment (Monthly payment)
                        // {
                        //     $payment_amount = Payment::calculatePayment(
                        //         $application->unit_amort_fin,
                        //         0.0
                        //     );

                        // Remove time from created_at
                        $dueDate = Carbon::parse($application->created_at)->startOfDay();

                        // Add 1 month to the due date
                        $dueDate->addMonth();

                        // Get the date only as a string
                        $dueDateOnly = $dueDate->toDateString();

                        $remaining = $application->remaining_balance - $application->monthly_payment;
                        // Now you can set the 'due_date' attribute
                        $set('due_date', $dueDateOnly);
                        $set('payment_amount', $application->monthly_payment);
                        $set('customer_application_id', $application->customer_application_id);
                        $set('application_full_name', $cust_app->applicant_full_name);
                        $set('application_unit', $cust_app->preffered_unit_status);
                        $set('application_balance', $application->remaining_balance);
                        $set('est_monthly_payment', $application->monthly_payment);
                        $set('application_unit_price', $application->original_amount);
                        $set('remaining', $remaining);
                    }
                ),
        ])
            ->columns(2);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make([
                    PaymentResource::getApplicationDetails()
                        ->columnSpan(3),
                    PaymentResource::getApplicationInformation()
                        ->columnSpan(3),
                ])
                    ->columns(3)
                    ->columnSpan(3),
                PaymentResource::getPaymentDetails()
                    ->columnSpan(3),
            ])
            ->columns(6);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customerApplication.applicant_full_name')
                    ->label('Full name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('payment_amount')
                    ->label('Payment Amount')
                    ->money('php'),
                Tables\Columns\TextColumn::make('remaining')
                    ->label('Remaining Balance')
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
