<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusinessIpRange extends Model
{
    protected $fillable = [
        'business_id',
        'ip_range_start',
        'ip_range_end',
        'label',
        'is_primary',
    ];

    protected $casts = [
        'ip_range_start' => 'integer',
        'ip_range_end' => 'integer',
        'is_primary' => 'boolean',
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function containsIp(int $ipLong): bool
    {
        return $ipLong >= $this->ip_range_start && $ipLong <= $this->ip_range_end;
    }
}
