<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\Client;
use App\Models\PageView;
use App\Services\Business\BusinessLeadScoringService;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoAnalyticsSeeder extends Seeder
{
    public function run(): void
    {
        $client = Client::first();

        if (! $client) {
            return;
        }

        $businesses = Business::with('ipRanges')->active()->get();
        $paths = ['/', '/pricing', '/about', '/contact', '/products', '/checkout', '/blog'];

        foreach ($businesses->take(8) as $business) {
            $range = $business->ipRanges->first();

            if (! $range) {
                continue;
            }

            $ip = $this->sampleIpFromRange($range->ip_range_start, $range->ip_range_end);
            $sessionId = Str::uuid()->toString();

            foreach (array_slice($paths, 0, rand(2, 5)) as $pathIndex => $path) {
                PageView::create([
                    'client_id' => $client->id,
                    'business_id' => $business->id,
                    'ip_address' => $ip,
                    'url_path' => $path,
                    'full_url' => "https://{$client->domain}{$path}",
                    'referrer' => $pathIndex === 0 ? 'https://google.com' : null,
                    'session_id' => $sessionId,
                    'device_type' => ['desktop', 'mobile', 'tablet'][array_rand(['desktop', 'mobile', 'tablet'])],
                    'screen_resolution' => '1920x1080',
                    'duration' => rand(30, 300),
                    'created_at' => Carbon::now()->subMinutes(rand(1, 120)),
                    'updated_at' => Carbon::now(),
                ]);
            }

            app(BusinessLeadScoringService::class)->scoreAndPersist($client, $business, $ip, $sessionId);
        }
    }

    private function sampleIpFromRange(int $start, int $end): string
    {
        $long = rand($start, min($end, $start + 254));
        $packed = pack('N', $long);

        return inet_ntop($packed) ?: '127.0.0.1';
    }
}
