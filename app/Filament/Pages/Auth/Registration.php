<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Form;
use Filament\Pages\Auth\Register;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Leandrocfe\FilamentPtbrFormFields\Document;
use Leandrocfe\FilamentPtbrFormFields\PhoneNumber;

class Registration extends Register
{
    public function getHeading(): string|Htmlable
    {
        return '';
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            $this->getNameFormComponent()->label('Nome'),
            $this->getEmailFormComponent()->label('Email'),
            Document::make('document')
                ->label('Documento')
                ->dynamic()
                ->required(),
            PhoneNumber::make('phone')
                ->label('Telefone')
                ->required(),
            $this->getPasswordFormComponent()->label('Senha'),
            $this->getPasswordConfirmationFormComponent()->label('Confirmar Senha')
        ]);
    }

    protected function getFormActions(): array
    {
        return [
            $this->getRegisterFormAction()->label('Cadastrar')
        ];
    }
}
