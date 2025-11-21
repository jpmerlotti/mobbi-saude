<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->password()
                    ->required(),
                TextInput::make('public_id')
                    ->required(),
                TextInput::make('phone')
                    ->tel(),
                TextInput::make('document'),
                TextInput::make('address_street'),
                TextInput::make('address_number'),
                TextInput::make('address_complement'),
                TextInput::make('address_district'),
                TextInput::make('address_city'),
                TextInput::make('address_state'),
                TextInput::make('address_zip_code'),
            ]);
    }
}
