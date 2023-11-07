<?php

namespace App\Filament\Auth;

use App\Models\User;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Facades\Filament;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Notifications\Notification;
use Filament\Pages\Auth\Login as BaseAuth;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Validation\ValidationException;

class Login extends BaseAuth
{

    public function getTitle(): string | Htmlable
    {
        return __('Admin');
    }

    public function getHeading(): string | Htmlable
    {
        return __('Admin');
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            $this->getLoginFormComponent(), 
            $this->getPasswordFormComponent(),
            $this->getRememberFormComponent(),
        ]);
    }

    public function authenticate(): ?LoginResponse
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            Notification::make()
                ->title(__('filament-panels::pages/auth/login.notifications.throttled.title', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]))
                ->body(array_key_exists('body', __('filament-panels::pages/auth/login.notifications.throttled') ?: []) ? __('filament-panels::pages/auth/login.notifications.throttled.body', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]) : null)
                ->danger()
                ->send();

            return null;
        }

        $data = $this->form->getState();

        // //check if user is a an admin, returns an error to page if not.
        // if(User::query()->where('id', $data["id"])->get()->first() != null){
        //     if(!User::query()->where('id', $data["id"])->get()->first()->is_admin){
        //         throw ValidationException::withMessages([
        //             'data.email' => __('filament-panels::pages/auth/login.messages.failed'),
        //             'data.employee_id' => __('filament-panels::pages/auth/login.messages.failed'),
        //         ]);
        //     }
        // }

        //checks if user is a filament user
        if (!Filament::auth()->attempt($this->getCredentialsFromFormData($data), $data['remember'] ?? false)) {
            throw ValidationException::withMessages([
                'data.email' => __('filament-panels::pages/auth/login.messages.failed'),
                'data.id' => __('filament-panels::pages/auth/login.messages.failed'),
            ]);
        }

        return app(LoginResponse::class);

    }

    

    protected function getLoginFormComponent(): Component 
    {
        return TextInput::make('id')
            ->label('User ID')
            ->required()
            ->autocomplete()
            ->autofocus();
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'id' => $data['id'],
            'password'  => $data['password'],
        ];
    }

}