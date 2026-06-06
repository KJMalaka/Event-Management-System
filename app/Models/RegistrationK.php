<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RegistrationK extends Model
{
    use HasFactory;

    protected $table = 'registrations';

    protected $fillable = [
        'event_id',
        'user_id',
        'status',
        'notes',
        'approved_at',
        'declined_at',
    ];

    protected function casts(): array
    {
        return [
            'approved_at' => 'datetime',
            'declined_at' => 'datetime',
        ];
    }

    // Relationships

    public function event(): BelongsTo
    {
        return $this->belongsTo(EventK::class, 'event_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeDeclined($query)
    {
        return $query->where('status', 'declined');
    }

    // Accessors

    public function getStatusBadgeColorAttribute(): string
    {
        return match ($this->status) {
            'approved'  => 'green',
            'pending'   => 'yellow',
            'declined'  => 'red',
            'cancelled' => 'gray',
            default     => 'gray',
        };
    }

    public function getIsApprovedAttribute(): bool
    {
        return $this->status === 'approved';
    }

    public function getIsPendingAttribute(): bool
    {
        return $this->status === 'pending';
    }
}
