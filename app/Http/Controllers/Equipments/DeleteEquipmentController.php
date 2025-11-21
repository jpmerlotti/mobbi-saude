<?php

namespace App\Http\Controllers\Equipments;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;

class DeleteEquipmentController extends Controller
{
    public function __invoke(string $public_id)
    {
        $equipment = Equipment::findByPulicId($public_id);

        if ($equipment) {
            $equipment->delete();

            Notification::make()
                ->success()
                ->title('Sucesso ao deletar equipamento.')
                ->send();

            return $this->return();
        }

        Notification::make()
            ->dander()
            ->title('Erro ao deletar equipamento.')
            ->send();

        return $this->return();
    }

    public function return()
    {
        return redirect()->route('my-equipments.index');
    }
}
