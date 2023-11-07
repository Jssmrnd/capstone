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
use Filament\Actions\Action;

class EditCustomerApplicationMaintenance extends Page
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?string $navigationLabel = 'Audit Trail';
    protected static ?string $navigationGroup = 'Utilities';
    protected static string $view = 'filament.pages.edit-customer-application';

    public ?array $data = [];

    public function mount()
    {
        $this->data = CustomerApplicationMaintenance::first();
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
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

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

}
