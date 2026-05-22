<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LiveFeedResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $company = $this->company;
        $pagesVisited = $this->resource->pages_visited ?? [];
        if (! is_array($pagesVisited)) {
            $pagesVisited = [];
        }
        $currentPage = count($pagesVisited) > 0
            ? $pagesVisited[array_key_last($pagesVisited)]
            : '/';

        return [
            'id' => $this->id,
            'company_name' => $company?->company_name,
            'industry' => $company?->industry,
            'current_page' => $currentPage,
            'lead_score' => $this->lead_score,
            'status' => $this->status,
            'last_active_at' => $this->last_active_at?->toIso8601String(),
            'last_active_human' => $this->last_active_at?->diffForHumans(),
        ];
    }
}
