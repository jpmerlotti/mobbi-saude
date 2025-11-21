<?php

namespace App\Livewire\Pages\User\MyEquipments;

use App\Livewire\Forms\EquipmentForm;
use App\Models\Equipment;
use App\Models\EquipmentImage;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Filament\Support\Exceptions\Halt;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Editar Equipamento'])]
class EditEquipment extends Component implements HasForms
{
    use InteractsWithForms;

    #[Url('equipment')]
    public Equipment $equipment;

    public bool $showModal = false;

    public array $data = [];

    public function mount(): void
    {
        $data = $this->equipment->toArray();

        $data['images'] = $this->equipment->images
            ->sortBy('sort')
            ->pluck('path')
            ->toArray();

        $this->form->fill($data);
    }

    public function openModal(): void
    {
        $this->showModal = true;
    }

    protected function handleSave(array $data): void
    {
        $equipment = $this->equipment;
        $images = $data['images'] ?? [];

        unset($data['images']);

        $equipment->update($data);

        $currentPaths = $this->equipment->images()->pluck('path')->toArray();
        $pathsToDelete = array_diff($currentPaths, $images);

        if (!empty($pathsToDelete)) {
            $this->equipment->images()->whereIn('path', $pathsToDelete)->delete();
        }

        foreach ($images as $index => $path) {
            $this->equipment->images()->updateOrCreate([
                'path' => $path,
                'sort' => $index + 1
            ]);
        }
    }

    public function save(): void
    {
        $data = $this->form->getState();

        try {
            $this->handleSave($data);
        } catch (\Exception $e) {
            $this->redirect(route('my-equipments.edit', ['equipment' => $this->equipment]), true);

            Notification::make()
                ->danger()
                ->title('Erro ao atualizar Equipamento.')
                ->body($e->getMessage())
                ->send();
        }

        Notification::make()
            ->success()
            ->title('Equipamento atualizado com sucesso.')
            ->send();
    }

    public function form(Schema $schema): Schema
    {
        return EquipmentForm::configure($schema, $this->equipment)
            ->statePath('data');
    }

    public function delete(): void
    {
        try {
            $this->equipment->delete();
        } catch (\Exception $e) {
            Notification::make()
                ->danger()
                ->title('Equipamento removido com sucesso.')
                ->body($e->getMessage())
                ->send();

            $this->redirect(route('my-equipments.edit', ['equipment' => $this->equipment]), true);

            return;
        }

        $this->redirect(route('my-equipments.index'), true);

        Notification::make()
            ->success()
            ->title('Equipamento removido com sucesso.')
            ->send();
    }

    public function render()
    {
        return view('livewire.pages.user.my-equipments.edit-equipment');
    }
}
