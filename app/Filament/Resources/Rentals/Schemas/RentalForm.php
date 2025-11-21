<?php

namespace App\Filament\Resources\Rentals\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RentalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('public_id')
                    ->required(),
                Select::make('equipment_id')
                    ->relationship('equipment', 'name')
                    ->required(),
                Select::make('borrower_id')
                    ->relationship('borrower', 'name')
                    ->required(),
                DateTimePicker::make('rented_at'),
                DateTimePicker::make('expected_return_at')
                    ->required(),
                DateTimePicker::make('returned_at'),
                TextInput::make('status')
                    ->required()
                    ->default('pending_approval'),
            ]);
    }
}
