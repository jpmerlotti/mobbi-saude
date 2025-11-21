<?php

namespace App\Livewire\Pages\User\MyEquipments;

use App\Livewire\Forms\EquipmentForm;
use App\Models\Equipment;
use App\Models\EquipmentType;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'My Equipments'])]
class Equipments extends Component
{
    public bool $showModal = false;

    public ?Equipment $deletingEquipment = null;

    public string $displayMode = 'grid';

    public function changeDisplayMode(string $mode): void
    {
        $this->displayMode = $mode;
    }

    public function delete($id): void
    {
        $this->deletingEquipment = Equipment::find($id);
        $this->showModal = true;
    }

    public function destroy(): void
    {
        try {
            $this->deletingEquipment->delete();
        } catch (\Exception $e) {
            $this->showModal = false;
            $this->deletingEquipment = null;

            return;

            Notification::make()
                ->danger()
                ->title('Erro ao deletar equipamento.')
                ->body($e->getMessage())
                ->send();
        }

        $this->showModal = false;
        $this->deletingEquipment = null;

        Notification::make()
            ->success()
            ->title('Equipamento deletado com sucesso.')
            ->send();
    }

    public function view(Equipment $equipment)
    {
        $this->redirect(route('show-equipment', ['equipment' => $equipment]), true);
    }

    #[Computed()]
    public function equipments()
    {
        return Auth::user()
            ->equipments()
            ->with('equipmentType')
            ->latest()
            ->get();
    }

    public function render()
    {
        return view('livewire.pages.user.my-equipments.equipments');
    }
}
