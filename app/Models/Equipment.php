<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Equipment extends Model
{
    use HasUuids;

    protected $table = 'equipments';

    protected $fillable = [
        'name',
        'description',
        'photo',
        'active',
        'equipment_type_id',
        'owner_id',
        'status',
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(EquipmentType::class);
    }
}
