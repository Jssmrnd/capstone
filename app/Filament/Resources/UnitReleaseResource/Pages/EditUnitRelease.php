<?php

namespace App\Filament\Resources\UnitReleaseResource\Pages;

use App\Filament\Resources\UnitReleaseResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditUnitRelease extends EditRecord
{
    protected static string $resource = UnitReleaseResource::class;

    protected function getFormActions(): array
    {
        return [
            EditUnitRelease::getSaveFormAction(),
        ];
    }


    protected function getSubmitFormAction(): Action
    {
        return $this->getSaveFormAction();
    }


    protected function getSaveFormAction(): Action
    {
        return Action::make('save')
            ->label("Release")
            ->submit('save')
            ->keyBindings(['mod+s']);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
