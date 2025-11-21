<?php

namespace App\Models;

use App\Traits\HasPublicId;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Concerns\HasUuid;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Equipment extends Model
{
    use HasPublicId;

    protected $table = 'equipments';

    protected $fillable = [
        'owner_id',
        'equipment_type_id',
        'name',
        'description',
        'daily_rate',
        'is_rented',
        'is_available'
    ];

    public function casts(): array
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    | Relacionamentos
    |--------------------------------------------------------------------------
    */

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id',     'id');
    }

    public function equipmentType(): BelongsTo
    {
        return $this->belongsTo(EquipmentType::class);
    }

    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
    }

    public function images(): HasMany
    {
        return $this->HasMany(EquipmentImage::class)->orderBy('sort');
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function thumbnail(): Attribute
    {
        return Attribute::make(get: function () {
            $path = $this->images->sortBy('sort')?->first()?->url;

            if (!$path) {
                return 'https://placehold.co/600x400/E2E8F0/4A5568?text=Sem+Fotos';
            }

            return $path;
        });
    }

    public function imageUrls()
    {
        $images = [];

        foreach ($this->images->sortBy('sort') as $img) {
            $images[] = $img->url;
        }

        return $images;
    }

    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('is_available', true);
    }
}
