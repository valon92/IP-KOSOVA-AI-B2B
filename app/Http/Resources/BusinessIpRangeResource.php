<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BusinessIpRangeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'label' => $this->label,
            'is_primary' => $this->is_primary,
            'ip_start' => $this->longToIp($this->ip_range_start),
            'ip_end' => $this->longToIp($this->ip_range_end),
            'ip_start_long' => $this->ip_range_start,
            'ip_end_long' => $this->ip_range_end,
        ];
    }

    private function longToIp(int $long): string
    {
        $packed = pack('N', $long);

        return inet_ntop($packed) ?: '0.0.0.0';
    }
}
