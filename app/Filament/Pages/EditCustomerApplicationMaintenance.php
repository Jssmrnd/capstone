<?php

namespace App\Filament\Pages;

use App\Models\Branch;
use Filament\Facades\Filament;
use App\Models\CustomerApplicationMaintenance;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Support\Exceptions\Halt;

class EditCustomerApplicationMaintenance extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?string $navigationLabel = 'Application Maintenance';
    protected static ?string $navigationGroup = 'Maintenance Module';
    protected static string $view = 'filament.pages.edit-customer-application';

    public ?array $data = [];

    public function mount()
    {
        $this->data = CustomerApplicationMaintenance::all()->toArray()[0];
    }

    protected function getFormActions(): array
    {
        return [
            Forms\Components\Actions\Action::make('save')
                ->label(__('filament-panels::resources/pages/edit-record.form.actions.save.label'))
                ->submit('save'),
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
            Forms\Components\TextInput::make("rebate_value"),
        ])
        ->statePath('data');
    }

    public function save(): void
    {
        try {
            $data = $this->form->getState();
            CustomerApplicationMaintenance::all()[0]->update($data);
        } catch (Halt $exception) {
            return;
        }
    }

}
