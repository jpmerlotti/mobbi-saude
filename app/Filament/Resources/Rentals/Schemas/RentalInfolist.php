<?php

namespace App\Filament\Resources\Rentals\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class RentalInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('public_id'),
                TextEntry::make('equipment.name')
                    ->label('Equipment'),
                TextEntry::make('borrower.name')
                    ->label('Borrower'),
                TextEntry::make('rented_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('expected_return_at')
                    ->dateTime(),
                TextEntry::make('returned_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('status'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
