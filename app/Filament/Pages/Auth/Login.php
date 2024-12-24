<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Form;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Contracts\Support\Htmlable;

class Login extends BaseLogin
{
    public function getHeading(): string|Htmlable
    {
        return '';
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            $this->getEmailFormComponent()->label('Email'),
            $this->getPasswordFormComponent()->label('Senha'),
            $this->getRememberFormComponent()->label('Lembrar-me')
        ]);
    }

    protected function getFormActions(): array
    {
        return [
            $this->getAuthenticateFormAction()->label('Entrar'),
        ];
    }
}
