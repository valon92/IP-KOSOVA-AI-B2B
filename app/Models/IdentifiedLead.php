<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IdentifiedLead extends Model
{
    protected $fillable = [
        'client_id',
        'company_id',
        'ip_address',
        'lead_score',
        'status',
        'total_time_spent',
        'visit_count',
        'pages_visited',
        'last_active_at',
    ];

    protected $casts = [
        'lead_score' => 'integer',
        'total_time_spent' => 'integer',
        'visit_count' => 'integer',
        'pages_visited' => 'array',
        'last_active_at' => 'datetime',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(CompanyDirectory::class, 'company_id');
    }

    public static function scoreToStatus(int $score): string
    {
        if ($score > 75) {
            return 'hot';
        }

        if ($score >= 40) {
            return 'medium';
        }

        return 'cold';
    }
}
