<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BusinessLeadResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $business = $this->business;

        return [
            'id' => $this->id,
            'lead_score' => $this->lead_score,
            'status' => $this->status,
            'pages_visited' => $this->pages_visited ?? [],
            'time_spent' => $this->formatDuration($this->total_time_spent),
            'time_spent_seconds' => $this->total_time_spent,
            'visit_count' => $this->visit_count,
            'ip_address' => $this->ip_address,
            'first_seen_at' => $this->first_seen_at?->toIso8601String(),
            'last_active_at' => $this->last_active_at?->toIso8601String(),
            'last_active_human' => $this->last_active_at?->diffForHumans(),
            'business' => $business ? new BusinessResource($business) : null,
            'company_name' => $business?->name,
            'location' => $business?->location,
            'industry' => $business?->industry?->name,
            'logo_url' => $business?->logo_url,
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
