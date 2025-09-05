<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'city',
        'workplace',
        'position',
        'academic_degree',
        'is_admin',
        'is_verified_manually',
        'membership_expires_at',
        'membership_type',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'membership_expires_at' => 'datetime',
            'is_admin' => 'boolean',
            'is_verified_manually' => 'boolean',
        ];
    }

    public function conferenceParticipations(): HasMany
    {
        return $this->hasMany(ConferenceParticipant::class);
    }

    public function conferenceAbstracts(): HasMany
    {
        return $this->hasMany(ConferenceAbstract::class);
    }

    public function hasMembershipFor($date = null): bool
    {
        $date = $date ?: now();
        return $this->membership_expires_at && $this->membership_expires_at->gte($date);
    }

    public function hasActiveMembership(): bool
    {
        return $this->hasMembershipFor();
    }

    public function isVerified(): bool
    {
        return $this->hasVerifiedEmail() || $this->is_verified_manually;
    }
}
