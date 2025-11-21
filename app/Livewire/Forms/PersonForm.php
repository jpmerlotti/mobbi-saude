<?php

namespace App\Livewire\Forms;

use App\Rules\CpfCnpj;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class PersonForm
{
    public static function configure(bool $required = false, string $fieldPrefix = ''): array
    {
        return [
            TextInput::make($fieldPrefix . 'full_name') // Use the correct field name (e.g., recipient_name) later
                ->required($required)
                ->label('Nome Completo'),
            TextInput::make($fieldPrefix . 'document') // Use the correct field name (e.g., recipient_document) later
                ->label('CPF') // Consider label 'CPF ou CNPJ' if CpfCnpj validates both
                ->required($required)
                ->rule(new CpfCnpj()),
            Fieldset::make('Contato')
                ->schema([
                    TextInput::make($fieldPrefix . 'email')
                        ->email()
                        ->required($required),
                    TextInput::make($fieldPrefix . 'phone')
                        ->label('Telefone')
                        ->required($required)
                        ->mask('(99) 99999-9999'),
                ]),
        ];
    }
}
