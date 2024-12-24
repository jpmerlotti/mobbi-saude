<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\EquipmentsList;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Dashboard;
use Filament\Pages\Dashboard\Actions\FilterAction;
use Filament\Pages\Dashboard\Concerns\HasFiltersAction;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Pages\Page;
use Laravel\Prompts\SearchPrompt;

class Home extends Dashboard
{
    use HasFiltersForm;

    protected static ?string $title = '';
    protected static ?string $navigationLabel = 'Home';
    protected static ?string $navigationIcon = 'heroicon-o-home';

    public function filtersForm(Form $form): Form
    {
        return $form->schema([
            Section::make()
                ->heading()
                ->schema([
                    TextInput::make('search')
                        ->label('O que você está precisando hoje?')
                        ->placeholder('Buscar por...')
                        ->suffixAction(
                            Action::make('seach')
                                ->icon('heroicon-o-magnifying-glass')
                        )
                ])
        ]);
    }

    public function getWidgets(): array
    {
        return [
            EquipmentsList::class,
        ];
    }
}
