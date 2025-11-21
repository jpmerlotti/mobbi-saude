<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Rules\CpfCnpj;
use App\Traits\HasPublicId;
use Carbon\Carbon;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Concerns\HasUuid;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory,
        Notifiable,
        MustVerifyEmail,
        HasApiTokens,
        HasPublicId;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'document',
        'address_street',
        'address_number',
        'address_complement',
        'address_district',
        'address_city',
        'address_state',
        'address_zip_code',
        'birth_date',
        'avatar_path',
        'terms_accepted_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'terms_accepted_at' => 'datetime',
            'password' => 'hashed',
            'document' => 'string',
        ];
    }

    protected static function booted(): void
    {
        parent::booted();

        static::creating(function (User $user) {
            if (! $user->public_id) {
                $user->public_id = Str::uuid();
            }
        });

        static::updating(function (User $user) {
            if ($user->isDirty('avatar_path')) {
                $oldPath = $user->getOriginal('avatar_path');
                if ($oldPath) {
                    Storage::disk('s3')->delete($oldPath);
                }
            }
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

    public function rentalsAsBorrower(): HasMany
    {
        return $this->hasMany(Rental::class, 'borrower_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function avatar(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->avatar_path) {
                    return Storage::disk('s3')
                        ->temporaryUrl(
                            $this->avatar_path,
                            now()->addHours(2)
                        );
                }

                return 'https://ui-avatars.com/api/?name='
                    . urlencode($this->name)
                    . '&background=random&color=fff';
            }
        );
    }

    public function isAdmin(): bool
    {
        return in_array($this->email, config('admin.users'));
    }

    public function hasCompletedProfile(): bool
    {
        $requiredFields = [$this->document, $this->phone, $this->birth_date];
        $test = true;

        foreach ($requiredFields as $field) {
            if (! isset($field)) {
                $test = false;
                break;
            }
        }

        return $test && (! (now()->diffInYears($this->birth_date) > 18));
    }

    /*
    |--------------------------------------------------------------------------
    | Admin Panel
    |--------------------------------------------------------------------------
    */

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin();
    }
}
