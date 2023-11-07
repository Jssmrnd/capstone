<?php

namespace App\Filament\Widgets;

use App\Models;
use App\Filament;
use App\Filament\Resources\CustomerApplicationResource;
use App\Models\CustomerApplication;
use Filament\Facades\Filament as FacadesFilament;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class CustomerDues extends BaseWidget
{

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                function (Builder $query){
                    return Models\CustomerApplication::query()->where('due_date', '!=', 'null')->latest();
                }
            )
            ->columns([
                Tables\Columns\TextColumn::make("id")
                        ->label("Application ID"),
                Tables\Columns\TextColumn::make("due_date")
                        ->dateTime('M d Y'),
                Tables\Columns\TextColumn::make("applicant_lastname"),
                Tables\Columns\TextColumn::make("unit_amort_fin")
                        ->label("Monthly Amort.")
                        ->money("php")
                        ->color("success"),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->url(fn (CustomerApplication $record): string => CustomerApplicationResource::getUrl('edit', ['record' => $record])),
            ]);
    }

    public function getPages():array
    {
        return [
            'view' => CustomerApplicationResource\Pages\ViewCustomerApplication::route('/{record}'),
        ];
    }

}
