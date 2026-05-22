<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageView extends Model
{
    protected $fillable = [
        'client_id',
        'company_id',
        'ip_address',
        'url_path',
        'full_url',
        'referrer',
        'session_id',
        'device_type',
        'screen_resolution',
        'duration',
    ];

    protected $casts = [
        'duration' => 'integer',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(CompanyDirectory::class, 'company_id');
    }
}
