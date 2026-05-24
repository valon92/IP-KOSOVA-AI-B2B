<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LiveFeedResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $business = $this->business;
        $pagesVisited = $this->pages_visited ?? [];
        $currentPage = count($pagesVisited) > 0
            ? $pagesVisited[array_key_last($pagesVisited)]
            : '/';

        return [
            'id' => $this->id,
            'lead_score' => $this->lead_score,
            'status' => $this->status,
            'current_page' => $currentPage,
            'last_active_at' => $this->last_active_at?->toIso8601String(),
            'last_active_human' => $this->last_active_at?->diffForHumans(),
            'business' => $business ? new BusinessResource($business) : null,
            'company_name' => $business?->name,
            'industry' => $business?->industry?->name,
        ];
    }
}
