<?php

namespace App\Models;

use App\Traits\HasPublicId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Support\Str;
use App\Enums\RentalStatus;
use App\Mail\NewRentalRequestMail;
use App\Mail\RentalStatusUpdatedMail;
use Illuminate\Support\Facades\Mail;

class Rental extends Model
{
    use HasPublicId;

    protected $fillable = [
        'equipment_id',
        'borrower_id',
        'expected_return_at',
        'status',
        'contact_name',
        'contact_email',
        'contact_phone',
        'contact_type',
        'contact_message',
        'contact_agree',
        'contact_agreed_at',
        'rejection_reason',
    ];

    public function casts(): array
    {
        return [
            'loaned_at' => 'datetime',
            'expected_return_at' => 'datetime',
            'returned_at' => 'datetime',
            'contact_agreed_at' => 'datetime',
            'status' => RentalStatus::class,
        ];
    }

    protected static function booted(): void
    {
        static::boot();

        static::creating(function (Rental $rental) {

            if (! $rental->public_id) {
                $rental->public_id = Str::uuid();
            }

            $rental->contact_agreed_at = now();
        });

        static::created(function (Rental $rental) {
            if ($rental->owner) {
                Mail::to($rental->owner->email)
                    ->send(new NewRentalRequestMail($rental));
            }
        });

        static::updated(function (Rental $rental) {

            if ($rental->isDirty('status')) {

                if ($rental->borrower) {
                    Mail::to($rental->borrower->email)
                        ->send(new RentalStatusUpdatedMail($rental));
                }
            }
        });
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
            'user_id'
        );
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }
}
