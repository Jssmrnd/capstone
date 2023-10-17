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
        //we can minimize this whole code by creating a function at the Model,
        //Analyze the neccessary functions before creating it.
        //Motorcycle Assignment

        return [
            
            //Approve Application
            Actions\Action::make("Approve")
                    ->color('success')
                    ->requiresConfirmation()
                    ->form([
                        Forms\Components\DatePicker::make('due_date')
                                ->format('Y-m-d')
                                ->label('Set Due Date'),
                    ])
                    ->action(function(array $data){
                        $this->record->approveThisApplication();
                        $this->getRecord()->due_date = $data['due_date'];   //sets the due date.
                        $this->getRecord()->save(); // sales the record
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

            //Reject Application,
            Actions\Action::make("Reject")
            ->color('danger')
            ->requiresConfirmation()
            ->form([
                Forms\Components\Textarea::make('reason')->label('Reason of Rejection:'),
            ])
            ->action(function(){
                $this->record->rejectThisApplication();
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
