<?php

namespace App\Filament\Resources\CustomerApplicationResource\Pages;

use App\Enums\ApplicationStatus;
use Filament\Forms;
use App\Filament\Resources\CustomerApplicationResource;
use App\Models\Unit;
use Filament\Actions;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\ViewRecord;

class ViewCustomerApplication extends ViewRecord
{
    protected static string $resource = CustomerApplicationResource::class;


protected function getHeaderActions(): array
    {
        return [
            //Approve Application
            Actions\Action::make("Approve")
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function(array $data){
                        $this->record->setStatusTo(ApplicationStatus::ACTIVE_STATUS);
                        $this->record->reject_note = null;
                        $this->getRecord()->save(); // saves the record
                    })->hidden(
                        function(array $data){
                            if($this->record->getStatus() == ApplicationStatus::REJECTED_STATUS 
                                    || $this->record->getStatus() == ApplicationStatus::ACTIVE_STATUS 
                                    || $this->record->getStatus() == ApplicationStatus::RESUBMISSION_STATUS)
                                {
                                return true;
                            }
                            return false;
                        }
                    ),
            Actions\Action::make("Resubmission")
                    ->slideOver()
                    ->color('info')
                    ->requiresConfirmation()
                    ->form([
                        Forms\Components\TextArea::make('resubmission_note')
                        ->required()
                        ->maxLength(255),
                    ])
                    ->action(function(array $data){
                        $this->record->setStatusTo(ApplicationStatus::RESUBMISSION_STATUS);
                        $this->record->resubmission_note = $data["resubmission_note"];
                        $this->record->reject_note = null;
                        Notification::make()
                                ->title('Application is now in resubmission')
                                ->success()
                                ->send();
                        $this->getRecord()->save(); // saves the record
                        $this->refreshFormData([
                            'application_status',
                        ]);
                    })->hidden(
                        function(array $data){
                            if(
                                $this->record->getStatus() 
                                    == ApplicationStatus::RESUBMISSION_STATUS) {
                                return true;
                            }
                            return false;
                        }
                    ),
            //Reject Application,
            Actions\Action::make("Reject")
            ->color('danger')
            ->slideOver()
            ->requiresConfirmation()
            ->form([
                Forms\Components\Textarea::make('reject_note')->label('Reason of Rejection:'),
            ])
            ->action(function(array $data){
                $this->record->setStatusTo(ApplicationStatus::REJECTED_STATUS);
                $this->record->reject_note = $data["reject_note"];
                $this->record->resubmission_note = null;
                $this->record->save();
                $this->refreshFormData([
                    'application_status',
                ]);
                Notification::make()
                ->title('This application has been rejected!')
                ->success()
                ->send();
            })->hidden(
                function(array $data){
                    if(
                        $this->getRecord()->application_status == ApplicationStatus::REJECTED_STATUS){
                        return true;
                    }
                    return false;
                }
            ),
            Actions\EditAction::make(),
        ];
    }
    

}
