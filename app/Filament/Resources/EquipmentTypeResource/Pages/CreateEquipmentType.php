<?php

namespace App\Filament\Resources\EquipmentTypeResource\Pages;

use App\Filament\Resources\EquipmentTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEquipmentType extends CreateRecord
{
    protected static string $resource = EquipmentTypeResource::class;
    protected static ?string $title = 'Cadastrar Tipo de Equipamento';

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction()->label('Cadastrar'),
            ...(static::canCreateAnother() ? [$this->getCreateAnotherFormAction()->label('Salvar e criar outro')] : []),
            $this->getCancelFormAction()->label('Cancelar'),
        ];
    }
}
