<?php

namespace App\Models;

use App\Enums\LeadStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientBusinessLead extends Model
{
    protected $table = 'client_business_leads';

    protected $fillable = [
        'client_id',
        'business_id',
        'ip_address',
        'lead_score',
        'status',
        'total_time_spent',
        'visit_count',
        'pages_visited',
        'first_seen_at',
        'last_active_at',
    ];

    protected $casts = [
        'lead_score' => 'integer',
        'total_time_spent' => 'integer',
        'visit_count' => 'integer',
        'pages_visited' => 'array',
        'first_seen_at' => 'datetime',
        'last_active_at' => 'datetime',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public static function statusFromScore(int $score): string
    {
        return LeadStatus::fromScore($score)->value;
    }
}
