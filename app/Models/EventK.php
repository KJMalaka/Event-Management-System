<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class EventK extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'events';

    protected $fillable = [
        'organizer_id',
        'category_id',
        'title',
        'slug',
        'description',
        'location',
        'venue',
        'start_date',
        'end_date',
        'capacity',
        'price',
        'status',
        'banner_image',
        'requires_approval',
    ];

    protected function casts(): array
    {
        return [
            'start_date'        => 'datetime',
            'end_date'          => 'datetime',
            'price'             => 'decimal:2',
            'requires_approval' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (EventK $event) {
            if (empty($event->slug)) {
                $event->slug = Str::slug($event->title) . '-' . Str::random(6);
            }
        });
    }

    // Relationships

    public function organizer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(CategoryK::class, 'category_id');
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(RegistrationK::class, 'event_id');
    }

    public function approvedRegistrations(): HasMany
    {
        return $this->hasMany(RegistrationK::class, 'event_id')->where('status', 'approved');
    }

    // Scopes

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>=', now())->orderBy('start_date');
    }

    public function scopePast($query)
    {
        return $query->where('end_date', '<', now());
    }

    public function scopeForOrganizer($query, int $userId)
    {
        return $query->where('organizer_id', $userId);
    }

    public function scopeByCategory($query, int $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    // Accessors

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getIsFreeAttribute(): bool
    {
        return (float) $this->price === 0.0;
    }

    public function getAvailableSpotsAttribute(): int
    {
        return max(0, $this->capacity - $this->approvedRegistrations()->count());
    }

    public function getIsFullAttribute(): bool
    {
        return $this->available_spots === 0;
    }

    public function getStatusBadgeColorAttribute(): string
    {
        return match ($this->status) {
            'published'  => 'green',
            'draft'      => 'gray',
            'cancelled'  => 'red',
            'completed'  => 'blue',
            default      => 'gray',
        };
    }

    public function getFormattedPriceAttribute(): string
    {
        return $this->is_free ? 'Free' : 'R ' . number_format($this->price, 2);
    }

    public function getDurationAttribute(): string
    {
        return $this->start_date->diffForHumans($this->end_date, true);
    }

    // Mutators

    public function setTitleAttribute(string $value): void
    {
        $this->attributes['title'] = ucwords(strtolower(trim($value)));
    }
}
