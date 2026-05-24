<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BusinessDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $lead = $request->attributes->get('detail_lead');
        $analytics = $request->attributes->get('detail_analytics');

        return [
            'business' => [
                'id' => $this->id,
                'name' => $this->name,
                'slug' => $this->slug,
                'legal_name' => $this->legal_name,
                'location' => $this->location,
                'city' => $this->city,
                'region' => $this->region,
                'country' => $this->country,
                'website' => $this->website,
                'logo_url' => $this->logo_url,
                'email' => $this->email,
                'phone' => $this->phone,
                'size_band' => $this->size_band,
                'description' => $this->description,
                'is_verified' => $this->is_verified,
                'is_active' => $this->is_active,
                'registered_at' => $this->metadata['registered_at'] ?? $this->created_at?->toIso8601String(),
                'industry' => $this->whenLoaded('industry', fn () => [
                    'id' => $this->industry->id,
                    'name' => $this->industry->name,
                    'slug' => $this->industry->slug,
                    'icon' => $this->industry->icon,
                ]),
            ],
            'ip_identity' => [
                'ranges' => BusinessIpRangeResource::collection($this->whenLoaded('ipRanges')),
                'primary_range' => $this->whenLoaded('ipRanges', function () {
                    $primary = $this->ipRanges->firstWhere('is_primary', true)
                        ?? $this->ipRanges->first();

                    return $primary ? new BusinessIpRangeResource($primary) : null;
                }),
                'identification_method' => 'Reverse IP lookup · Kosovo corporate registry',
            ],
            'lead' => $lead,
            'analytics' => $analytics,
        ];
    }
}
