<?php

namespace App\Services\Business;

use App\Models\Client;
use App\Models\ClientBusinessLead;
use App\Models\PageView;
use Carbon\Carbon;

class BusinessAnalyticsService
{
    public function metricsForClient(Client $client): array
    {
        $totalVisits = PageView::where('client_id', $client->id)->count();
        $uniqueBusinesses = ClientBusinessLead::where('client_id', $client->id)
            ->distinct()
            ->count('business_id');
        $avgLeadScore = (float) ClientBusinessLead::where('client_id', $client->id)->avg('lead_score') ?: 0;
        $hotLeads = ClientBusinessLead::where('client_id', $client->id)->where('status', 'hot')->count();
        $conversionRate = $uniqueBusinesses > 0
            ? round(($hotLeads / $uniqueBusinesses) * 100, 1)
            : 0;

        return [
            'total_visits' => $totalVisits,
            'unique_businesses' => $uniqueBusinesses,
            'unique_companies' => $uniqueBusinesses,
            'average_lead_score' => round($avgLeadScore, 1),
            'conversion_rate' => $conversionRate,
            'hot_leads' => $hotLeads,
        ];
    }

    public function liveLeadsForClient(Client $client, ?int $withinMinutes = null): \Illuminate\Database\Eloquent\Collection
    {
        $minutes = $withinMinutes ?? config('business.live_feed_minutes', 30);
        $since = Carbon::now()->subMinutes($minutes);

        return ClientBusinessLead::query()
            ->with(['business.industry'])
            ->where('client_id', $client->id)
            ->where('last_active_at', '>=', $since)
            ->orderByDesc('last_active_at')
            ->limit(15)
            ->get();
    }

    public function leadsForClient(Client $client, int $perPage = 25): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return ClientBusinessLead::query()
            ->with(['business.industry', 'business.ipRanges'])
            ->where('client_id', $client->id)
            ->orderByDesc('lead_score')
            ->orderByDesc('last_active_at')
            ->paginate($perPage);
    }
}
