<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class Client extends Authenticatable
{
    use HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
        'api_key',
        'domain',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'api_key',
        'remember_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'password' => 'hashed',
    ];

    protected static function booted(): void
    {
        static::creating(function (Client $client) {
            if (empty($client->api_key)) {
                $client->api_key = 'ipko_'.Str::random(40);
            }
        });
    }

    public function pageViews(): HasMany
    {
        return $this->hasMany(PageView::class);
    }

    public function businessLeads(): HasMany
    {
        return $this->hasMany(ClientBusinessLead::class);
    }
}
