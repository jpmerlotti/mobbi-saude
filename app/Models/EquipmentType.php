<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EquipmentType extends Model
{
    use HasUuids;

    protected $table = 'equipment_types';

    protected $fillable = [
        'name',
        'description'
    ];

    public function equipments(): HasMany
    {
        return $this->hasMnay(Equipment::class);
    }
}
