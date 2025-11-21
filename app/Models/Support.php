<?php

namespace App\Models;

use App\Enums\SupportStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Support extends Model
{
    protected $fillable = [
        'author_id',
        'full_name',
        'email',
        'phone',
        'subject',
        'message',
        'status'
    ];

    public function casts(): array
    {
        return [
            'status' => SupportStatus::class,
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }
}
