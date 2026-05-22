<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        Client::updateOrCreate(
            ['domain' => 'demo.ipko.ai'],
            [
                'name' => 'IPKO Demo Client',
                'api_key' => 'ipko_demo_key_for_mvp_development',
                'is_active' => true,
            ]
        );
    }
}
