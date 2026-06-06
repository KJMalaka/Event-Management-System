<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'avatar',
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
        ];
    }

    // Relationships

    public function organizedEvents(): HasMany
    {
        return $this->hasMany(EventK::class, 'organizer_id');
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(RegistrationK::class);
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLogK::class);
    }

    // Scopes

    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeOrganizers($query)
    {
        return $query->where('role', 'organizer');
    }

    public function scopeAttendees($query)
    {
        return $query->where('role', 'attendee');
    }

    // Role helpers

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isOrganizer(): bool
    {
        return $this->role === 'organizer';
    }

    public function isAttendee(): bool
    {
        return $this->role === 'attendee';
    }

    public function canManageEvents(): bool
    {
        return in_array($this->role, ['admin', 'organizer']);
    }

    // Accessors

    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar
            ? asset('storage/' . $this->avatar)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=3B82F6&color=fff';
    }

    public function getRoleLabelAttribute(): string
    {
        return ucfirst($this->role);
    }
}
