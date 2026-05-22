<?php

namespace App\Services;

use App\Helpers\IpHelper;
use App\Models\CompanyDirectory;
use Illuminate\Support\Facades\Cache;

class IpEnrichmentService
{
    private const CACHE_TTL = 3600;

    public function resolve(string $ipAddress): ?CompanyDirectory
    {
        $ipLong = IpHelper::toLong($ipAddress);

        if ($ipLong === 0) {
            return null;
        }

        $cacheKey = "ipko:company:{$ipLong}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($ipLong) {
            return CompanyDirectory::query()
                ->where('ip_range_start', '<=', $ipLong)
                ->where('ip_range_end', '>=', $ipLong)
                ->first();
        });
    }

    public function resolveWithFallback(string $ipAddress): array
    {
        $company = $this->resolve($ipAddress);

        if ($company) {
            return [
                'identified' => true,
                'company' => $company,
            ];
        }

        return [
            'identified' => false,
            'company' => null,
        ];
    }
}
