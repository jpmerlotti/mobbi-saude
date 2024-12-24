<?php

namespace App\Services\Equipment;

use App\Models\Equipment;
use App\Services\Service;

class EquipmentService extends Service
{
    public function validate(array $data = [], string $context = 'create'): bool
    {
        $rules = match ($context) {
            'create' => [
                'name' => 'string|required|'
            ],
            'update' => [],
            'show' => [],
        };

        return true;
    }

    public function create($data): Equipment
    {
        try {
            $equipment = Equipment::create($data);
            return $equipment;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
