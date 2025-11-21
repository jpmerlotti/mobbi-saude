<?php

use App\Models\EquipmentType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected array $defaultEquipmentTypes = [
        [
            'name' => 'Andador',
            'description' => 'Andadores para adultos/idosos.'
        ],
        [
            'name' => 'Bengala',
            'description' => 'Bengalas diversas para adultos/idosos'
        ],
        [
            'name' => 'Bota hortopédica',
            'description' => 'Botas hortopédicas para adultos/idosos.'
        ],
        [
            'name' => 'Cadeira de Banho',
            'description' => 'Cadeiras de banho para adultos/idosos.'
        ],
        [
            'name' => 'Cadeira de Rodas',
            'description' => 'Cadeiras de rodas para adultos/idosos.'
        ],
        [
            'name' => 'Cama Hospitalar',
            'description' => 'Camas hospitalares.'
        ],
        [
            'name' => 'Equipamento Infantil',
            'description' => 'Equipamentos diversos para crianças.'
        ],
        [
            'name' => 'Inalador',
            'description' => 'Inaladores diversos para adultos/idosos.'
        ],
        [
            'name' => 'Maca',
            'description' => 'Macas diversas para transporte de doentes.'
        ],
        [
            'name' => 'Muletas',
            'description' => 'Muletas diversas para adultos/idosos.'
        ],
        [
            'name' => 'Respirador',
            'description' => 'Respiradores diversos para adultos/idosos.'
        ],
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->defaultEquipmentTypes as $type) {
            EquipmentType::create($type);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        EquipmentType::all()->map(fn (EquipmentType $type) => $type->delete());
    }
};
