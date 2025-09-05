<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conference extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'registration_opens_at',
        'starts_at',
        'ends_at',
        'location',
        'conference_type',
        'announcement',
        'important_dates',
        'events',
        'description',
        'post_release',
        'materials',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'registration_opens_at' => 'date',
            'starts_at' => 'date',
            'ends_at' => 'date',
            'important_dates' => 'array',
            'events' => 'array',
            'materials' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function participants(): HasMany
    {
        return $this->hasMany(ConferenceParticipant::class);
    }

    public function abstracts(): HasMany
    {
        return $this->hasMany(ConferenceAbstract::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeCurrent($query)
    {
        return $query->where('starts_at', '>=', now()->toDateString());
    }

    public function scopeUpcoming($query)
    {
        return $query->where('starts_at', '>=', now()->toDateString())
                    ->where('is_active', true)
                    ->orderBy('starts_at', 'asc');
    }

    public function scopePast($query)
    {
        return $query->where('starts_at', '<', now()->toDateString())
                    ->where('is_active', true)
                    ->orderBy('starts_at', 'desc');
    }

    public function isRegistrationOpen(): bool
    {
        return $this->registration_opens_at <= now()->toDateString() && 
               $this->starts_at >= now()->toDateString();
    }

    public function isFinished(): bool
    {
        $endDate = $this->ends_at ?: $this->starts_at;
        return $endDate < now()->toDateString();
    }
}
