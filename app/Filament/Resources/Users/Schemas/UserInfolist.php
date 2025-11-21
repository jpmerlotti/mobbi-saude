<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('email_verified_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('public_id'),
                TextEntry::make('phone')
                    ->placeholder('-'),
                TextEntry::make('document')
                    ->placeholder('-'),
                TextEntry::make('address_street')
                    ->placeholder('-'),
                TextEntry::make('address_number')
                    ->placeholder('-'),
                TextEntry::make('address_complement')
                    ->placeholder('-'),
                TextEntry::make('address_district')
                    ->placeholder('-'),
                TextEntry::make('address_city')
                    ->placeholder('-'),
                TextEntry::make('address_state')
                    ->placeholder('-'),
                TextEntry::make('address_zip_code')
                    ->placeholder('-'),
            ]);
    }
}
