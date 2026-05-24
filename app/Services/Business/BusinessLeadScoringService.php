<?php

namespace App\Services\Business;

use App\Models\Business;
use App\Models\Client;
use App\Models\ClientBusinessLead;
use App\Models\PageView;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class BusinessLeadScoringService
{
    public function scoreAndPersist(
        Client $client,
        Business $business,
        string $ipAddress,
        string $sessionId,
        int $additionalDuration = 0
    ): ClientBusinessLead {
        $pageViews = PageView::query()
            ->where('client_id', $client->id)
            ->where('ip_address', $ipAddress)
            ->where('business_id', $business->id)
            ->orderBy('created_at')
            ->get();

        $totalDuration = (int) $pageViews->sum('duration') + $additionalDuration;
        $pagesVisited = $this->uniquePaths($pageViews);
        $visitCount = $this->distinctSessions($client->id, $ipAddress, $business->id, 7);
        $highValueHit = $this->visitedHighValuePage($pagesVisited);
        $leadScore = min(100, $this->computeScore($totalDuration, $highValueHit, $visitCount));

        $existing = ClientBusinessLead::query()
            ->where('client_id', $client->id)
            ->where('business_id', $business->id)
            ->where('ip_address', $ipAddress)
            ->first();

        return ClientBusinessLead::updateOrCreate(
            [
                'client_id' => $client->id,
                'business_id' => $business->id,
                'ip_address' => $ipAddress,
            ],
            [
                'lead_score' => $leadScore,
                'status' => ClientBusinessLead::statusFromScore($leadScore),
                'total_time_spent' => $totalDuration,
                'visit_count' => $visitCount,
                'pages_visited' => $pagesVisited,
                'first_seen_at' => $existing?->first_seen_at ?? now(),
                'last_active_at' => now(),
            ]
        );
    }

    private function computeScore(int $totalDurationSeconds, bool $highValueHit, int $visitCount): int
    {
        $config = config('business.scoring');
        $score = 0;

        $minutes = (int) floor($totalDurationSeconds / 60);
        $score += min(
            $config['max_time_points'],
            $minutes * $config['points_per_minute']
        );

        if ($highValueHit) {
            $score += config('business.high_value_page_bonus');
        }

        foreach (array_reverse($config['visit_bonus'], true) as $threshold => $bonus) {
            if ($visitCount >= $threshold) {
                $score += $bonus;
                break;
            }
        }

        return $score;
    }

    private function uniquePaths(Collection $pageViews): array
    {
        return $pageViews
            ->pluck('url_path')
            ->unique()
            ->values()
            ->take(20)
            ->all();
    }

    private function visitedHighValuePage(array $paths): bool
    {
        $patterns = config('business.high_value_url_patterns', []);

        foreach ($paths as $path) {
            $lower = strtolower($path);

            foreach ($patterns as $pattern) {
                if (str_contains($lower, $pattern)) {
                    return true;
                }
            }
        }

        return false;
    }

    private function distinctSessions(int $clientId, string $ip, int $businessId, int $days): int
    {
        return (int) PageView::query()
            ->where('client_id', $clientId)
            ->where('ip_address', $ip)
            ->where('business_id', $businessId)
            ->where('created_at', '>=', Carbon::now()->subDays($days))
            ->distinct()
            ->count('session_id');
    }
}
