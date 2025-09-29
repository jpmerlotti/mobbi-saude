<?php

namespace App\Models;

use App\Traits\HasPublicId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Rental extends Model
{
    use HasPublicId;

    protected $fillable = [
        'equipment_id',
        'borrower_id',
        'expected_return_at',
        'status',
    ];

    public function casts(): array
    {
        return [
            'loaned_at' => 'datetime',
            'expected_return_at' => 'datetime',
            'returned_at' => 'datetime',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relacionamentos
    |--------------------------------------------------------------------------
    */
    
    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function borrower(): BelongsTo
    {
        return $this->belongsTo(User::class, 'borrower_id');
    }

    public function owner(): HasOneThrough
    {
        return $this->hasOneThrough(
            User::class,
            Equipment::class,
            'id', 
            'id', 
            'equipment_id', 
            'owner_id' 
        );
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }
}
