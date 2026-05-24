<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\BusinessLeadResource;
use App\Http\Resources\LiveFeedResource;
use App\Models\Client;
use App\Services\Business\BusinessAnalyticsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(
        private readonly BusinessAnalyticsService $analytics
    ) {}

    public function metrics(Request $request): JsonResponse
    {
        $client = $this->client($request);

        return response()->json([
            'data' => $this->analytics->metricsForClient($client),
        ]);
    }

    public function liveFeed(Request $request): JsonResponse
    {
        $client = $this->client($request);
        $leads = $this->analytics->liveLeadsForClient($client);

        return response()->json([
            'data' => LiveFeedResource::collection($leads)->resolve(),
        ]);
    }

    public function businessLeads(Request $request): JsonResponse
    {
        $client = $this->client($request);
        $leads = $this->analytics->leadsForClient(
            $client,
            $request->integer('per_page', 25)
        );

        return BusinessLeadResource::collection($leads)->response();
    }

    /** @deprecated Use businessLeads — kept for backward compatibility */
    public function companies(Request $request): JsonResponse
    {
        return $this->businessLeads($request);
    }

    private function client(Request $request): Client
    {
        return Auth::guard('client')->user();
    }
}
