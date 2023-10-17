<?php

namespace App\Filament\TestPanel\Resources\PaymentResource\Pages;

use App\Filament\TestPanel\Resources\PaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePayment extends CreateRecord
{
    protected static string $resource = PaymentResource::class;
}
