<?php

namespace App\Models;

use App\Traits\HasPublicId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Contract extends Model
{
    use HasPublicId;

    protected $fillable = [
        'rental_id',
        'type',
        'content',
        'status',
        'pdf_path'
    ];

    public function casts(): array
    {
        return [
            'lessee_signed_at' => 'datetime',
            'lessor_signed_at' => 'datetime',
            'lessee_signature_data' => 'array',
            'lessor_signature_data' => 'array',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relacionamentos
    |--------------------------------------------------------------------------
    */

    public function rental(): BelongsTo
    {
        return $this->belongsTo(Rental::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function pdf()
    {
        return Storage::disk('public')->url($this->pdf_path);
    }

    public function isSignedByLessee(): bool
    {
        return $this->lessee_signed_at !== null;
    }

    public function isSignedByLessor(): bool
    {
        return $this->lessor_signed_at !== null;
    }

    public function isFullySigned(): bool
    {
        return $this->isSignedByLessee() && $this->isSignedByLessor();
    }
}
