<?php

namespace Database\Seeders;

use App\Helpers\IpHelper;
use App\Models\Business;
use App\Models\BusinessIpRange;
use App\Models\Industry;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BusinessSeeder extends Seeder
{
    public function run(): void
    {
        $entries = [
            [
                'ip_start' => '185.132.40.0',
                'ip_end' => '185.132.40.255',
                'name' => 'NLB Banka HQ',
                'industry' => 'banking',
                'city' => 'Prishtinë',
                'size_band' => '500+',
                'website' => 'https://www.nlb-kos.com',
                'description' => 'Qendra kryesore e NLB Bank në Kosovë.',
            ],
            [
                'ip_start' => '185.132.41.0',
                'ip_end' => '185.132.41.127',
                'name' => 'Raiffeisen Bank Kosovo',
                'industry' => 'banking',
                'city' => 'Prishtinë',
                'size_band' => '201-500',
                'website' => 'https://www.raiffeisen-kosovo.com',
            ],
            [
                'ip_start' => '185.132.42.0',
                'ip_end' => '185.132.42.255',
                'name' => 'Albi Mall',
                'industry' => 'retail',
                'city' => 'Prishtinë',
                'size_band' => '201-500',
                'website' => 'https://www.albimall.com',
            ],
            [
                'ip_start' => '185.132.43.0',
                'ip_end' => '185.132.43.63',
                'name' => 'Ministria e Financave',
                'industry' => 'qeveri',
                'city' => 'Prishtinë',
                'size_band' => '500+',
                'website' => 'https://www.mf-rks.org',
            ],
            [
                'ip_start' => '185.132.44.0',
                'ip_end' => '185.132.44.255',
                'name' => 'Trepharm Pharmaceutical',
                'industry' => 'farmaci',
                'city' => 'Prishtinë',
                'size_band' => '51-200',
                'website' => 'https://www.trepharm.com',
            ],
            [
                'ip_start' => '185.132.45.0',
                'ip_end' => '185.132.45.127',
                'name' => 'Balfin Group',
                'industry' => 'ndertimtari',
                'city' => 'Prishtinë',
                'size_band' => '500+',
                'website' => 'https://www.balfin.al',
            ],
            [
                'ip_start' => '185.132.46.0',
                'ip_end' => '185.132.46.255',
                'name' => 'KEDS - Kosovo Energy',
                'industry' => 'energji',
                'city' => 'Prishtinë',
                'size_band' => '500+',
                'website' => 'https://www.keds-energy.com',
            ],
            [
                'ip_start' => '185.132.48.0',
                'ip_end' => '185.132.48.255',
                'name' => 'Viva Fresh Store',
                'industry' => 'retail',
                'city' => 'Prizren',
                'size_band' => '201-500',
                'website' => 'https://www.vivafresh.com',
            ],
            [
                'ip_start' => '185.132.49.0',
                'ip_end' => '185.132.49.127',
                'name' => 'Stone Castle Winery',
                'industry' => 'agrobiznes',
                'city' => 'Rahovec',
                'size_band' => '51-200',
                'website' => 'https://www.stonecastle-ks.com',
            ],
            [
                'ip_start' => '127.0.0.0',
                'ip_end' => '127.0.0.255',
                'name' => 'IPKO Demo Corp (Local)',
                'industry' => 'teknologji',
                'city' => 'Prishtinë',
                'size_band' => '11-50',
                'website' => 'https://ipko.ai',
            ],
        ];

        foreach ($entries as $entry) {
            $industry = Industry::where('slug', $entry['industry'])->first();

            if (! $industry) {
                continue;
            }

            $business = Business::updateOrCreate(
                ['slug' => Str::slug($entry['name'])],
                [
                    'industry_id' => $industry->id,
                    'name' => $entry['name'],
                    'legal_name' => $entry['name'],
                    'city' => $entry['city'],
                    'region' => 'Kosovë',
                    'country' => 'XK',
                    'website' => $entry['website'],
                    'size_band' => $entry['size_band'] ?? '51-200',
                    'description' => $entry['description'] ?? null,
                    'is_verified' => true,
                    'is_active' => true,
                ]
            );

            BusinessIpRange::updateOrCreate(
                [
                    'business_id' => $business->id,
                    'label' => 'HQ',
                ],
                [
                    'ip_range_start' => IpHelper::toLong($entry['ip_start']),
                    'ip_range_end' => IpHelper::toLong($entry['ip_end']),
                    'is_primary' => true,
                ]
            );
        }
    }
}
