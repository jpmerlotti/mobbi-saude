<?php

namespace App\Filament\Resources\EquipmentResource\Pages;

use App\Filament\Resources\EquipmentResource;
use App\Services\Equipment\EquipmentService;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateEquipment extends CreateRecord
{
    protected static ?string $title = 'Cadastrar Equipamento';
    protected static string $resource = EquipmentResource::class;

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction()->label('Cadastrar'),
            ...(static::canCreateAnother() ? [$this->getCreateAnotherFormAction()->label('Salvar e criar outro')] : []),
            $this->getCancelFormAction()->label('Cancelar'),
        ];
    }

    protected function handleRecordCreation(array $data): Model
    {
        $service = app(EquipmentService::class);
        $data['owner_id'] = auth()->user()->id;
        return $service->create($data);
    }
}
