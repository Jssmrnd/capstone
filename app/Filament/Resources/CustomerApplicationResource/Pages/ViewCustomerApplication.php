<?php

namespace App\Filament\Resources\CustomerApplicationResource\Pages;

use Filament\Forms;
use App\Filament\Resources\CustomerApplicationResource;
use App\Models\Unit;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCustomerApplication extends ViewRecord
{
    protected static string $resource = CustomerApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make("Approve")
                    ->color('success')
                    ->requiresConfirmation()
                    ->form([
                        Forms\Components\DatePicker::make('due_date')
                                ->format('d-m-Y')
                                ->label('Set Due Date'),
                    ])
                    ->action(function(array $data){
                        $this->getRecord()->application_status = 'active';
                        $this->getRecord()->due_date = $data['due_date'];
                        $this->getRecord()->is_application_approved = true;
                        $this->getRecord()->is_application_rejected = false;
                        $unit = Unit::query()->find($this->getRecord()->unit_id);
                        $unit->unit_quantity -= 1;
                        $unit->save();
                        $this->getRecord()->save();
                        $this->refreshFormData([
                            'application_status',
                        ]);
                    })->hidden(
                        function(array $data){
                            if($this->getRecord()->is_application_approved == 1){
                                return true;
                            }
                            return false;
                        }
                    ),

            Actions\Action::make("Reject")
            ->color('danger')
            ->requiresConfirmation()
            ->form([
                Forms\Components\Textarea::make('reason')->label('Reason of Rejection:'),
            ])
            ->action(function(){
                $this->getRecord()->application_status = 'reject';
                $this->getRecord()->due_date = null;
                $this->getRecord()->is_application_approved = false;
                $this->getRecord()->is_application_rejected = true;
                $unit = Unit::query()->find($this->getRecord()->unit_id);
                $unit->unit_quantity += 1;
                $unit->save();
                $this->getRecord()->save();
                $this->refreshFormData([
                    'application_status',
                ]);
            })->hidden(
                function(array $data){
                    if($this->getRecord()->is_application_rejected == 1){
                        return true;
                    }
                    return false;
                }
            ),
            Actions\EditAction::make(),
        ];
    }
    

}
