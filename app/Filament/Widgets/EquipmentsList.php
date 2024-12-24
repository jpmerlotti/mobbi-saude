<?php

namespace App\Filament\Widgets;

use App\Models\Equipment;
use App\Models\User;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Contracts\Database\Eloquent\Builder;

class EquipmentsList extends BaseWidget
{
    use InteractsWithPageFilters;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $search = $this->filters['search'];
        return $table
            ->heading('Equipamentos')
            ->emptyStateHeading('Não encontramos nenhum equipamento disponível :(')
            ->query(
                fn() => Equipment::query()
                    ->when($search == null, fn() => Equipment::where('active', true))
                    ->when($search, fn() => Equipment::where('name', 'like', "%$search%"))
            )
            ->columns([
                ImageColumn::make('photo')
                    ->alignCenter()
                    ->label('Foto')
                    ->circular(),
                TextColumn::make('name')
                    ->label('Nome')
                    ->description(fn($record) => $record->description),
                TextColumn::make('active')
                    ->alignCenter()
                    ->label('Disponível')
                    ->formatStateUsing(fn(bool $state): string => $state ? 'Sim' : 'Não')
                    ->color(fn(bool $state): string => $state ? 'success' : 'danger')
                    ->badge(),
                TextColumn::make('status')
                    ->alignCenter()
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
            ])
            ->actions([
                Action::make('view.equipment')
                    ->label('Ver')
                    ->icon('heroicon-o-eye'),
                Action::make('locate.equipment')
                    ->color('secondary')
                    ->label('Solicitar Aluguel')
                    ->icon('heroicon-o-plus')
            ]);
    }
}
