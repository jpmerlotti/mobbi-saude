<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\Equipments;
use App\Filament\Resources\EquipmentTypeResource\Pages;
use App\Filament\Resources\EquipmentTypeResource\RelationManagers;
use App\Models\EquipmentType;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EquipmentTypeResource extends Resource
{
    protected static ?string $model = EquipmentType::class;
    protected static ?string $navigationLabel = 'Tipos de Equipamento';
    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $cluster = Equipments::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nome')
                    ->required(),
                Textarea::make('description')
                    ->label('Descrição'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('Nenhum registro encontrado :(')
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->description(fn($record) => $record->description)
                // TextColumn::make('')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Editar')
                    ->color('secondary'),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEquipmentTypes::route('/'),
            'create' => Pages\CreateEquipmentType::route('/create'),
            'edit' => Pages\EditEquipmentType::route('/{record}/edit'),
        ];
    }
}
