<?php

namespace App\Filament\Resources;

use App\Enums\EquipmentStatusEnum;
use App\Filament\Clusters\Equipments;
use App\Filament\Resources\EquipmentResource\Pages;
use App\Filament\Resources\EquipmentResource\RelationManagers;
use App\Filament\Resources\EquipmentTypeResource\Pages\CreateEquipmentType;
use App\Models\Equipment;
use App\Models\EquipmentType;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use GrahamCampbell\ResultType\Success;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EquipmentResource extends Resource
{
    protected static ?string $model = Equipment::class;
    protected static ?string $navigationLabel = 'Equipamentos';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $cluster = Equipments::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('photo')
                    ->label('Foto/Imagem')
                    ->url()
                    ->suffixIcon('heroicon-o-globe-alt')
                    ->required(),
                TextInput::make('name')
                    ->label('Nome')
                    ->required(),
                Select::make('equipment_type_id')
                    ->label('Tipo')
                    ->placeholder('Selecione uma opção')
                    ->options(EquipmentType::all()->pluck('name', 'id'))
                    ->suffixAction(Action::make('create.equipmentType')
                        ->color('primary')
                        ->icon('heroicon-o-plus')
                        ->action(fn() => redirect(route(CreateEquipmentType::getRouteName()))))
                    ->searchable()
                    ->searchPrompt('Digite para buscar...')
                    ->noSearchResultsMessage('Nenhum tipo encontrado de equipamento :(')
                    ->required(),
                Select::make('status')
                    ->label('Condição')
                    ->placeholder('Selecione uma opção')
                    ->options(EquipmentStatusEnum::toArray())
                    ->required(),
                Textarea::make('description')
                    ->label('Descrição')
                    ->columnSpanFull(),
                Toggle::make('active')
                    ->label('Ativo')
                    ->inlineLabel()
                    ->onColor('secondary')
                    ->onIcon('heroicon-o-check')
                    ->offIcon('heroicon-o-x-mark'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('Nenhum registro encontrado :(')
            ->modifyQueryUsing(fn(Builder $query) => $query->where('owner_id', auth()->user()->id))
            ->columns([
                ImageColumn::make('photo')
                    ->alignCenter()
                    ->label('Foto')
                    ->circular(),
                TextColumn::make('name')
                    ->label('Nome')
                    ->description(fn($record) => $record->description),
                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->color(fn(string $state) => match ($state) {
                        'new' => 'success',
                        'used' => 'warning',
                        'damage' => 'danger'
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'new' => 'Novo',
                        'used' => 'Usado',
                        'damage' => 'Com danos'
                    }),
                ToggleColumn::make('active')
                    ->alignCenter()
                    ->label('Anúncio Ativo')
                    ->onColor('secondary')
                    ->onIcon('heroicon-o-check')
                    ->offIcon('heroicon-o-x-mark')
                // ->offColor()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Editar')
                    ->color('secondary'),
            ])
            ->bulkActions([]);
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
            'index' => Pages\ListEquipment::route('/'),
            'create' => Pages\CreateEquipment::route('/create'),
            'edit' => Pages\EditEquipment::route('/{record}/edit'),
        ];
    }
}
