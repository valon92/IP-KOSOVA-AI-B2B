<?php

namespace Database\Seeders;

use App\Helpers\IpHelper;
use App\Models\CompanyDirectory;
use Illuminate\Database\Seeder;

class CompanyDirectorySeeder extends Seeder
{
    public function run(): void
    {
        $companies = [
            [
                'ip_start' => '185.132.40.0',
                'ip_end' => '185.132.40.255',
                'company_name' => 'NLB Banka HQ',
                'industry' => 'Banking',
                'city' => 'Prishtinë',
                'website' => 'https://www.nlb-kos.com',
            ],
            [
                'ip_start' => '185.132.41.0',
                'ip_end' => '185.132.41.127',
                'company_name' => 'Raiffeisen Bank Kosovo',
                'industry' => 'Banking',
                'city' => 'Prishtinë',
                'website' => 'https://www.raiffeisen-kosovo.com',
            ],
            [
                'ip_start' => '185.132.42.0',
                'ip_end' => '185.132.42.255',
                'company_name' => 'Albi Mall',
                'industry' => 'Retail',
                'city' => 'Prishtinë',
                'website' => 'https://www.albimall.com',
            ],
            [
                'ip_start' => '185.132.43.0',
                'ip_end' => '185.132.43.63',
                'company_name' => 'Ministria e Financave',
                'industry' => 'Qeveri',
                'city' => 'Prishtinë',
                'website' => 'https://www.mf-rks.org',
            ],
            [
                'ip_start' => '185.132.44.0',
                'ip_end' => '185.132.44.255',
                'company_name' => 'Trepharm Pharmaceutical',
                'industry' => 'Farmaci',
                'city' => 'Prishtinë',
                'website' => 'https://www.trepharm.com',
            ],
            [
                'ip_start' => '185.132.45.0',
                'ip_end' => '185.132.45.127',
                'company_name' => 'Balfin Group',
                'industry' => 'Ndërtimtari',
                'city' => 'Prishtinë',
                'website' => 'https://www.balfin.al',
            ],
            [
                'ip_start' => '185.132.46.0',
                'ip_end' => '185.132.46.255',
                'company_name' => 'KEDS - Kosovo Energy',
                'industry' => 'Energji',
                'city' => 'Prishtinë',
                'website' => 'https://www.keds-energy.com',
            ],
            [
                'ip_start' => '185.132.47.0',
                'ip_end' => '185.132.47.63',
                'company_name' => 'IPKO Telecommunications',
                'industry' => 'Telekomunikacion',
                'city' => 'Prishtinë',
                'website' => 'https://www.ipko.com',
            ],
            [
                'ip_start' => '185.132.48.0',
                'ip_end' => '185.132.48.255',
                'company_name' => 'Viva Fresh Store',
                'industry' => 'Retail',
                'city' => 'Prizren',
                'website' => 'https://www.vivafresh.com',
            ],
            [
                'ip_start' => '185.132.49.0',
                'ip_end' => '185.132.49.127',
                'company_name' => 'Stone Castle Winery',
                'industry' => 'Agrobiznes',
                'city' => 'Rahovec',
                'website' => 'https://www.stonecastle-ks.com',
            ],
            [
                'ip_start' => '127.0.0.0',
                'ip_end' => '127.0.0.255',
                'company_name' => 'IPKO Demo Corp (Local)',
                'industry' => 'Teknologji',
                'city' => 'Prishtinë',
                'website' => 'https://ipko.ai',
            ],
        ];

        foreach ($companies as $entry) {
            CompanyDirectory::updateOrCreate(
                [
                    'company_name' => $entry['company_name'],
                ],
                [
                    'ip_range_start' => IpHelper::toLong($entry['ip_start']),
                    'ip_range_end' => IpHelper::toLong($entry['ip_end']),
                    'industry' => $entry['industry'],
                    'city' => $entry['city'],
                    'region' => 'Kosovë',
                    'website' => $entry['website'],
                    'logo_url' => null,
                ]
            );
        }
    }
}
