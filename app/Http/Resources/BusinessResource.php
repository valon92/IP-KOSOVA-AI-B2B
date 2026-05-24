<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BusinessResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
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
            'industry' => new IndustryResource($this->whenLoaded('industry')),
            'ip_ranges' => $this->whenLoaded('ipRanges', fn () => $this->ipRanges->map(fn ($r) => [
                'label' => $r->label,
                'is_primary' => $r->is_primary,
            ])),
        ];
    }
}
