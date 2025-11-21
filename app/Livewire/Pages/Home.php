<?php

namespace App\Livewire\Pages;

use App\Models\Equipment;
use App\Models\EquipmentType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app', ['title' => 'Home'])]
class Home extends Component implements HasForms
{
    use WithPagination, InteractsWithForms;

    public string $displayMode = 'grid';
    public array $filters = [
        'search',
        'type',
        'onlyAvailable',
        'onlyCity'
    ];

    protected $queryString = [
        'filters',
    ];

    public function mount(): void
    {
        $this->filters = [
            'search',
            'type',
            'onlyAvailable' => false,
            'onlyCity' => Auth::check()
        ];
        $this->form->fill($this->filters);
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['search', 'typeFilter'])) {
            $this->resetPage();
        }
    }

    public function changeDisplayMode(string $mode)
    {
        $this->displayMode = $mode;
    }

    #[Computed]
    public function equipments()
    {
        return Equipment::query()->with(['equipmentType', 'images', 'owner'])
            ->when($this->filters['search'], fn ($query) => $query->where('name', 'LIKE', "%" . $this->filters['search'] . "%"))
            ->when($this->filters['type'], fn ($query) => $query->where('equipment_type_id', $this->filters['type']))
            ->when($this->filters['onlyAvailable'], fn ($query) => $query->where('is_available', true))
            ->when(($this->filters['onlyCity'] && Auth::check() && Auth::user()->city || false),
                fn ($query) => $query->where('owner.city', Auth::user()->address_city))
            ->latest()
            ->paginate(12);
    }

    #[Computed(true)]
    public function types(): Collection
    {
        return EquipmentType::orderBy('name')->get();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns([
                'xs' => 1,
                'md' => 2
            ])
            ->components([
                TextInput::make('search')
                    ->live(debounce: 300)
                    ->label('Buscar por')
                    ->columnSpan(1),
                Select::make('type')
                    ->label('Tipo')
                    ->live()
                    ->options(fn () => $this->types()->pluck('name', 'id'))
                    ->columnSpan(1),
                Toggle::make('onlyAvailable')
                    ->inline(false)
                    ->label('Apenas Disponíveis')
                    ->live(),
                Toggle::make('onlyCity')
                    ->label('Apenas na minha cidade')
                    ->inline(false)
                    ->live()
                    ->visible(fn () => Auth::check() && !is_null(Auth::user()->address_city)),
            ])
            ->columns([
                'xs' => 1,
                'md' => 4
            ])
            ->statePath('filters');
    }

    public function render()
    {
        return view('livewire.pages.home');
    }
}
