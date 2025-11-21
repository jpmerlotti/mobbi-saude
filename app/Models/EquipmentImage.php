<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class EquipmentImage extends Model
{
    protected $fillable = [
        'equipment_id',
        'path',
        'sort'
    ];

    protected static function booted(): void
    {
        static::deleting(function (EquipmentImage $record) {
            Storage::disk('s3')->delete($record->path);
        });
    }

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function url(): Attribute
    {
        return Attribute::make(get: function () {
                return Storage::disk('s3')->temporaryUrl(
                    $this->path,
                    now()->addHours(2)
                );
            }
        );
    }
}

