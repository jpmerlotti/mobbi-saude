<?php

namespace App\Livewire\Pages\User\MyEquipments;

use App\Livewire\Forms\EquipmentForm;
use App\Models\Equipment;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Cadastrar Equipmento'])]
class CreateEquipment extends Component implements HasForms
{
    use InteractsWithForms;

    public array $data = [];

    public function mount(): void
    {
        $this->data = [
            'images' => [],
            'name' => '',
            'description' => '',
            'is_available' => false,
        ];
    }

    public function form(Schema $schema): Schema
    {
        return EquipmentForm::configure($schema, null)
            ->statePath('data');
    }

    protected function handleSave(array $data): void
    {
        $tmpImagesPaths = $data['images'] ?? [];
        unset($data['images']);

        try {
            $equipment = Auth::user()->equipments()->create($data);

            if (!empty($tmpImagesPaths)) {
                foreach ($tmpImagesPaths as $key => $tmp) {
                    $newPath = 'equipments/' . $equipment->id . '/' . basename($tmp);
                    Storage::disk('s3')->move($tmp, $newPath);

                    $equipment->images()->create([
                        'path' => $newPath,
                        'sort' => $key + 1
                    ]);
                }
            }

            return;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function save()
    {
        $data = $this->form->getState();

        try {

            $this->handleSave($data);
        } catch (\Exception $e) {
            Notification::make()
                ->danger()
                ->title('Erro ao cadastrar equipamento')
                ->body($e->getMessage())
                ->send();

            return;
        }

        $this->redirect(route('my-equipments.index'), true);

        Notification::make()
            ->success()
            ->title('Equipamento cadastrado com sucesso.')
            ->send();
    }

    public function render()
    {
        return view('livewire.pages.user.my-equipments.create-equipment');
    }
}
