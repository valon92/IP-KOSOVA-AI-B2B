<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IdentifiedLeadResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $company = $this->company;

        return [
            'id' => $this->id,
            'company_name' => $company?->company_name,
            'logo_url' => $company?->logo_url,
            'location' => $company ? "{$company->city}, {$company->region}" : null,
            'industry' => $company?->industry,
            'pages_visited' => $this->pages_visited ?? [],
            'time_spent' => $this->formatDuration($this->total_time_spent),
            'time_spent_seconds' => $this->total_time_spent,
            'lead_score' => $this->lead_score,
            'status' => $this->status,
            'visit_count' => $this->visit_count,
            'last_active_at' => $this->last_active_at?->toIso8601String(),
            'last_active_human' => $this->last_active_at?->diffForHumans(),
        ];
    }

    private function formatDuration(int $seconds): string
    {
        if ($seconds < 60) {
            return "{$seconds}s";
        }

        $minutes = (int) floor($seconds / 60);
        $remaining = $seconds % 60;

        return "{$minutes}m {$remaining}s";
    }
}
