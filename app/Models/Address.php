<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasUuids;

    protected $table = 'address';

    protected $fillable = [
        'user_id',
        'city',
        'street',
        'district',
        'state',
        'number',
        'complement',
        'cep',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
