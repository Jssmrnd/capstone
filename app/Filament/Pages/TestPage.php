<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Artisan;

class TestPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.test-page';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('edit'),
            Action::make('delete')
                ->requiresConfirmation()
                ->action(function(){
                    Artisan::call('backup:run');
                }),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}
