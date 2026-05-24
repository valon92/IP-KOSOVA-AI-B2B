<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class StatusController extends Controller
{
    public function index(): JsonResponse
    {
        $started = microtime(true);

        $dbOk = $this->checkDatabase();
        $cacheOk = $this->checkCache();

        $latencyMs = (int) round((microtime(true) - $started) * 1000);

        $services = [
            $this->service('Tracking API', '/api/v1/track', $dbOk, $latencyMs),
            $this->service('Dashboard API', '/api/v1/dashboard/*', $dbOk, $latencyMs),
            $this->service('IP Enrichment Engine', 'BusinessRegistryService', $dbOk, $latencyMs),
            $this->service('Business Registry', 'businesses + ip_ranges', $dbOk && Business::query()->exists(), $latencyMs),
            $this->service('Lead Scoring Engine', 'BusinessLeadScoringService', $dbOk, $latencyMs),
            $this->service('Session & Auth', '/login · Sanctum', $dbOk && Client::query()->where('is_active', true)->exists(), $latencyMs),
        ];

        $allOperational = collect($services)->every(fn (array $s) => $s['status'] === 'operational');
        $degraded = ! $allOperational && collect($services)->contains(fn (array $s) => $s['status'] === 'operational');

        return response()->json([
            'data' => [
                'status' => $allOperational ? 'operational' : ($degraded ? 'degraded' : 'outage'),
                'status_label' => $allOperational ? 'Të gjitha sistemet operacionale' : ($degraded ? 'Performancë e reduktuar' : 'Ndërprerje'),
                'checked_at' => now()->toIso8601String(),
                'region' => 'EU / Kosovë',
                'version' => 'MVP 1.0',
                'services' => $services,
                'metrics' => [
                    'active_clients' => Client::query()->where('is_active', true)->count(),
                    'registered_businesses' => Business::query()->where('is_active', true)->count(),
                    'cache' => $cacheOk ? 'operational' : 'degraded',
                ],
            ],
        ]);
    }

    private function checkDatabase(): bool
    {
        try {
            DB::connection()->getPdo();

            return true;
        } catch (\Throwable) {
            return false;
        }
    }

    private function checkCache(): bool
    {
        try {
            Cache::put('ipko_status_probe', true, 10);

            return Cache::get('ipko_status_probe') === true;
        } catch (\Throwable) {
            return false;
        }
    }

    private function service(string $name, string $component, bool $healthy, int $latencyMs): array
    {
        return [
            'name' => $name,
            'component' => $component,
            'status' => $healthy ? 'operational' : 'outage',
            'status_label' => $healthy ? 'Operacional' : 'Jo i disponueshëm',
            'latency_ms' => $healthy ? $latencyMs : null,
        ];
    }
}
