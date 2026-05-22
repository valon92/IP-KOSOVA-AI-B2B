<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\IdentifiedLeadResource;
use App\Http\Resources\LiveFeedResource;
use App\Models\Client;
use App\Models\IdentifiedLead;
use App\Models\PageView;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function metrics(Request $request): JsonResponse
    {
        $client = $this->resolveClient($request);

        $totalVisits = PageView::where('client_id', $client->id)->count();
        $uniqueCompanies = IdentifiedLead::where('client_id', $client->id)
            ->distinct()
            ->count('company_id');
        $avgLeadScore = (float) IdentifiedLead::where('client_id', $client->id)->avg('lead_score') ?: 0;
        $hotLeads = IdentifiedLead::where('client_id', $client->id)->where('status', 'hot')->count();
        $conversionRate = $uniqueCompanies > 0
            ? round(($hotLeads / $uniqueCompanies) * 100, 1)
            : 0;

        return response()->json([
            'data' => [
                'total_visits' => $totalVisits,
                'unique_companies' => $uniqueCompanies,
                'average_lead_score' => round($avgLeadScore, 1),
                'conversion_rate' => $conversionRate,
            ],
        ]);
    }

    public function liveFeed(Request $request): JsonResponse
    {
        $client = $this->resolveClient($request);
        $since = Carbon::now()->subMinutes(30);

        $leads = IdentifiedLead::query()
            ->with('company')
            ->where('client_id', $client->id)
            ->where('last_active_at', '>=', $since)
            ->orderByDesc('last_active_at')
            ->limit(15)
            ->get();

        return response()->json([
            'data' => LiveFeedResource::collection($leads)->resolve(),
        ]);
    }

    public function companies(Request $request): JsonResponse
    {
        $client = $this->resolveClient($request);

        $leads = IdentifiedLead::query()
            ->with('company')
            ->where('client_id', $client->id)
            ->orderByDesc('lead_score')
            ->orderByDesc('last_active_at')
            ->paginate($request->integer('per_page', 25));

        return IdentifiedLeadResource::collection($leads)->response();
    }

    private function resolveClient(Request $request): Client
    {
        return $request->attributes->get('client');
    }
}
