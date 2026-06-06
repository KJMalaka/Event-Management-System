<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class CategoryK extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'color',
    ];

    protected static function booted(): void
    {
        static::creating(function (CategoryK $category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    // Relationships

    public function events(): HasMany
    {
        return $this->hasMany(EventK::class, 'category_id');
    }

    // Scopes

    public function scopeWithEventCount($query)
    {
        return $query->withCount('events');
    }

    // Accessors

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
