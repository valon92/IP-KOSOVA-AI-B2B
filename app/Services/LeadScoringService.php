<?php

namespace App\Services;

use App\Models\Client;
use App\Models\CompanyDirectory;
use App\Models\IdentifiedLead;
use App\Models\PageView;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class LeadScoringService
{
    private const HIGH_VALUE_PATTERNS = [
        '/pricing',
        '/checkout',
        '/contact',
        '/demo',
        '/enterprise',
    ];

    private const HIGH_VALUE_BONUS = 30;

    public function calculate(
        Client $client,
        CompanyDirectory $company,
        string $ipAddress,
        string $sessionId,
        int $additionalDuration = 0
    ): IdentifiedLead {
        $pageViews = PageView::query()
            ->where('client_id', $client->id)
            ->where('ip_address', $ipAddress)
            ->where('company_id', $company->id)
            ->orderBy('created_at')
            ->get();

        $totalDuration = (int) $pageViews->sum('duration') + $additionalDuration;
        $pagesVisited = $this->collectUniquePaths($pageViews);
        $visitCount = $this->countVisitsWithinDays($client->id, $ipAddress, $company->id, 7);
        $highValueHit = $this->hasHighValuePage($pagesVisited);

        $score = $this->computeScore($totalDuration, $highValueHit, $visitCount);

        return IdentifiedLead::updateOrCreate(
            [
                'client_id' => $client->id,
                'company_id' => $company->id,
                'ip_address' => $ipAddress,
            ],
            [
                'lead_score' => min(100, $score),
                'status' => IdentifiedLead::scoreToStatus(min(100, $score)),
                'total_time_spent' => $totalDuration,
                'visit_count' => $visitCount,
                'pages_visited' => $pagesVisited,
                'last_active_at' => now(),
            ]
        );
    }

    private function computeScore(int $totalDurationSeconds, bool $highValueHit, int $visitCount): int
    {
        $score = 0;

        $minutes = (int) floor($totalDurationSeconds / 60);
        $score += min(40, $minutes * 5);

        if ($highValueHit) {
            $score += self::HIGH_VALUE_BONUS;
        }

        if ($visitCount >= 5) {
            $score += 25;
        } elseif ($visitCount >= 3) {
            $score += 15;
        } elseif ($visitCount >= 2) {
            $score += 8;
        }

        return $score;
    }

    private function collectUniquePaths(Collection $pageViews): array
    {
        return $pageViews
            ->pluck('url_path')
            ->unique()
            ->values()
            ->take(20)
            ->all();
    }

    private function hasHighValuePage(array $paths): bool
    {
        foreach ($paths as $path) {
            $lower = strtolower($path);

            foreach (self::HIGH_VALUE_PATTERNS as $pattern) {
                if (str_contains($lower, $pattern)) {
                    return true;
                }
            }
        }

        return false;
    }

    private function countVisitsWithinDays(int $clientId, string $ip, int $companyId, int $days): int
    {
        $since = Carbon::now()->subDays($days);

        return (int) PageView::query()
            ->where('client_id', $clientId)
            ->where('ip_address', $ip)
            ->where('company_id', $companyId)
            ->where('created_at', '>=', $since)
            ->distinct()
            ->count('session_id');
    }
}
