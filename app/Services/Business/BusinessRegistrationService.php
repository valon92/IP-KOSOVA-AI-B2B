<?php

namespace App\Services\Business;

use App\Helpers\IpHelper;
use App\Models\Business;
use App\Models\BusinessIpRange;
use App\Models\Client;
use App\Models\ClientBusinessLead;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class BusinessRegistrationService
{
    public function register(array $data): Business
    {
        $ipStart = IpHelper::toLong($data['ip_start']);
        $ipEnd = IpHelper::toLong($data['ip_end']);

        if ($ipStart === 0 || $ipEnd === 0) {
            throw ValidationException::withMessages([
                'ip_start' => ['Adresa IP nuk është e vlefshme.'],
            ]);
        }

        if ($ipStart > $ipEnd) {
            throw ValidationException::withMessages([
                'ip_end' => ['IP fundi duhet të jetë më i madh ose i barabartë me IP fillimin.'],
            ]);
        }

        $overlap = BusinessIpRange::query()
            ->where('ip_range_start', '<=', $ipEnd)
            ->where('ip_range_end', '>=', $ipStart)
            ->exists();

        if ($overlap) {
            throw ValidationException::withMessages([
                'ip_start' => ['Ky interval IP ekziston tashmë në regjistër.'],
            ]);
        }

        $autoVerify = config('business.auto_verify_registrations', false);
        $slug = $this->uniqueSlug($data['name']);

        return DB::transaction(function () use ($data, $ipStart, $ipEnd, $autoVerify, $slug) {
            $business = Business::create([
                'industry_id' => $data['industry_id'],
                'name' => $data['name'],
                'slug' => $slug,
                'legal_name' => $data['name'],
                'city' => $data['city'],
                'region' => $data['region'] ?? 'Kosovë',
                'country' => 'XK',
                'website' => $data['website'] ?? null,
                'email' => $data['email'] ?? null,
                'phone' => $data['phone'] ?? null,
                'size_band' => $data['size_band'] ?? '51-200',
                'description' => $data['description'] ?? null,
                'is_verified' => $autoVerify,
                'is_active' => true,
                'metadata' => array_filter([
                    'contact_name' => $data['contact_name'] ?? null,
                    'registered_via' => 'platform',
                    'registered_at' => now()->toIso8601String(),
                ]),
            ]);

            BusinessIpRange::create([
                'business_id' => $business->id,
                'ip_range_start' => $ipStart,
                'ip_range_end' => $ipEnd,
                'label' => $data['ip_label'] ?? 'HQ',
                'is_primary' => true,
            ]);

            $this->clearIpLookupCache($ipStart, $ipEnd);
            $this->bootstrapDashboardLead($business, $data['ip_start'] ?? inet_ntop(pack('N', $ipStart)));

            return $business->load(['industry', 'ipRanges']);
        });
    }

    private function clearIpLookupCache(int $ipStart, int $ipEnd): void
    {
        for ($ip = $ipStart; $ip <= min($ipEnd, $ipStart + 512); $ip++) {
            Cache::forget("ipko:business:ip:{$ip}");
        }
    }

    /** Shfaq biznesin në dashboard menjëherë pas regjistrimit (para vizitës së parë). */
    private function bootstrapDashboardLead(Business $business, string $ipAddress): void
    {
        $client = Client::query()->where('is_active', true)->orderBy('id')->first();

        if (! $client) {
            return;
        }

        ClientBusinessLead::updateOrCreate(
            [
                'client_id' => $client->id,
                'business_id' => $business->id,
                'ip_address' => $ipAddress,
            ],
            [
                'lead_score' => 0,
                'status' => 'cold',
                'total_time_spent' => 0,
                'visit_count' => 0,
                'pages_visited' => [],
                'first_seen_at' => now(),
                'last_active_at' => now(),
            ]
        );
    }

    private function uniqueSlug(string $name): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $counter = 1;

        while (Business::where('slug', $slug)->exists()) {
            $slug = "{$base}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
