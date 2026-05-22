<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CompanyDirectory extends Model
{
    protected $table = 'companies_directory';

    protected $fillable = [
        'ip_range_start',
        'ip_range_end',
        'company_name',
        'industry',
        'city',
        'region',
        'website',
        'logo_url',
    ];

    protected $casts = [
        'ip_range_start' => 'integer',
        'ip_range_end' => 'integer',
    ];

    public function pageViews(): HasMany
    {
        return $this->hasMany(PageView::class, 'company_id');
    }

    public function identifiedLeads(): HasMany
    {
        return $this->hasMany(IdentifiedLead::class, 'company_id');
    }

    public function getLocationAttribute(): string
    {
        return "{$this->city}, {$this->region}";
    }
}
