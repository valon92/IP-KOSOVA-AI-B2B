<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Business extends Model
{
    protected $fillable = [
        'industry_id',
        'name',
        'slug',
        'legal_name',
        'city',
        'region',
        'country',
        'website',
        'logo_url',
        'email',
        'phone',
        'size_band',
        'description',
        'is_verified',
        'is_active',
        'metadata',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'is_active' => 'boolean',
        'metadata' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function (Business $business) {
            if (empty($business->slug)) {
                $business->slug = Str::slug($business->name);
            }
        });
    }

    public function industry(): BelongsTo
    {
        return $this->belongsTo(Industry::class);
    }

    public function ipRanges(): HasMany
    {
        return $this->hasMany(BusinessIpRange::class);
    }

    public function pageViews(): HasMany
    {
        return $this->hasMany(PageView::class);
    }

    public function clientLeads(): HasMany
    {
        return $this->hasMany(ClientBusinessLead::class);
    }

    public function getLocationAttribute(): string
    {
        return "{$this->city}, {$this->region}";
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
