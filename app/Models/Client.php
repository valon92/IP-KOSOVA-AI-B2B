<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Client extends Model
{
    protected $fillable = [
        'name',
        'api_key',
        'domain',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Client $client) {
            if (empty($client->api_key)) {
                $client->api_key = Str::random(48);
            }
        });
    }

    public function pageViews(): HasMany
    {
        return $this->hasMany(PageView::class);
    }

    public function identifiedLeads(): HasMany
    {
        return $this->hasMany(IdentifiedLead::class);
    }
}
