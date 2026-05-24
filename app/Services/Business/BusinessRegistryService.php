<?php

namespace App\Services\Business;

use App\Helpers\IpHelper;
use App\Models\Business;
use App\Models\BusinessIpRange;
use Illuminate\Support\Facades\Cache;

class BusinessRegistryService
{
    private const CACHE_TTL = 3600;

    public function resolveByIp(string $ipAddress): ?Business
    {
        $ipLong = IpHelper::toLong($ipAddress);

        if ($ipLong === 0) {
            return null;
        }

        $cacheKey = "ipko:business:ip:{$ipLong}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($ipLong) {
            $range = BusinessIpRange::query()
                ->with(['business.industry'])
                ->whereHas('business', fn ($q) => $q->active()->where('is_verified', true))
                ->where('ip_range_start', '<=', $ipLong)
                ->where('ip_range_end', '>=', $ipLong)
                ->orderByDesc('is_primary')
                ->first();

            return $range?->business;
        });
    }

    public function resolveWithMeta(string $ipAddress): array
    {
        $business = $this->resolveByIp($ipAddress);

        return [
            'identified' => $business !== null,
            'business' => $business,
        ];
    }
}
