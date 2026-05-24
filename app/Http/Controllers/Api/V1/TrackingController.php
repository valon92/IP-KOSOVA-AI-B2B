<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrackPageViewRequest;
use App\Models\Client;
use App\Models\PageView;
use App\Services\Business\BusinessLeadScoringService;
use App\Services\Business\BusinessRegistryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class TrackingController extends Controller
{
    public function __construct(
        private readonly BusinessRegistryService $businessRegistry,
        private readonly BusinessLeadScoringService $leadScoring
    ) {}

    public function track(TrackPageViewRequest $request): JsonResponse
    {
        /** @var Client $client */
        $client = $request->attributes->get('client');
        $ipAddress = $request->ip() ?? '0.0.0.0';
        $url = $request->validated('url');
        $urlPath = parse_url($url, PHP_URL_PATH) ?: '/';
        $event = $request->validated('event') ?? 'pageview';
        $sessionId = $request->validated('session_id');
        $duration = (int) ($request->validated('duration') ?? 0);

        if ($event === 'ping' || $event === 'beacon') {
            return $this->handlePing($client, $sessionId, $ipAddress, $duration);
        }

        $resolution = $this->businessRegistry->resolveWithMeta($ipAddress);
        $business = $resolution['business'];

        $pageView = PageView::create([
            'client_id' => $client->id,
            'business_id' => $business?->id,
            'ip_address' => $ipAddress,
            'url_path' => Str::limit($urlPath, 500, ''),
            'full_url' => Str::limit($url, 2000, ''),
            'referrer' => $request->validated('referrer'),
            'session_id' => $sessionId,
            'device_type' => $request->validated('device_type'),
            'screen_resolution' => $request->validated('screen_resolution'),
            'duration' => $duration,
        ]);

        if ($business) {
            $this->leadScoring->scoreAndPersist($client, $business, $ipAddress, $sessionId, $duration);
        }

        return response()->json([
            'success' => true,
            'tracked' => true,
            'identified' => $resolution['identified'],
            'business_id' => $business?->id,
            'business_name' => $business?->name,
            'page_view_id' => $pageView->id,
        ], 201);
    }

    private function handlePing(Client $client, string $sessionId, string $ipAddress, int $duration): JsonResponse
    {
        $pageView = PageView::query()
            ->where('client_id', $client->id)
            ->where('session_id', $sessionId)
            ->where('ip_address', $ipAddress)
            ->latest('id')
            ->first();

        if (! $pageView) {
            return response()->json(['success' => true, 'tracked' => false], 200);
        }

        if ($duration > 0) {
            $pageView->update([
                'duration' => $pageView->duration + $duration,
            ]);
        }

        $business = $pageView->business;

        if ($business) {
            $this->leadScoring->scoreAndPersist(
                $client,
                $business,
                $ipAddress,
                $sessionId,
                $duration
            );
        }

        return response()->json([
            'success' => true,
            'tracked' => true,
            'event' => 'ping',
        ]);
    }
}
