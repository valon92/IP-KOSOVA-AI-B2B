<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $client = Client::query()
            ->where('api_key', 'ipko_demo_key_for_mvp_development')
            ->orWhere('email', 'demo@ipko.ai')
            ->first();

        $attributes = [
            'name' => 'IPKO Demo Client',
            'email' => 'demo@ipko.ai',
            'password' => 'ipko-demo-2026',
            'domain' => 'demo.ipko.ai',
            'api_key' => 'ipko_demo_key_for_mvp_development',
            'is_active' => true,
        ];

        if ($client) {
            $client->update($attributes);
        } else {
            Client::create($attributes);
        }
    }
}
