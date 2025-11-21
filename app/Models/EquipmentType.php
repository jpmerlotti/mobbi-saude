<?php

namespace App\Models;

use App\Traits\HasPublicId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class EquipmentType extends Model
{
    use HasPublicId;

    protected $fillable = [
        'name',
        'description',
    ];

    protected static function booted(): void
    {
        static::creating(function (EquipmentType $type) {
            $type->public_id = Str::uuid();
            $type->slug = str($type->name)->slug();
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relacionamentos
    |--------------------------------------------------------------------------
    */

    public function equipments(): HasMany
    {
        return $this->hasMany(Equipment::class);
    }
}
