<?php

namespace Database\Seeders;

use App\Models\Industry;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class IndustrySeeder extends Seeder
{
    public function run(): void
    {
        $industries = [
            ['name' => 'Banking', 'icon' => '🏦', 'order' => 1],
            ['name' => 'Retail', 'icon' => '🛒', 'order' => 2],
            ['name' => 'Qeveri', 'icon' => '🏛️', 'order' => 3],
            ['name' => 'Farmaci', 'icon' => '💊', 'order' => 4],
            ['name' => 'Ndërtimtari', 'icon' => '🏗️', 'order' => 5],
            ['name' => 'Energji', 'icon' => '⚡', 'order' => 6],
            ['name' => 'Telekomunikacion', 'icon' => '📡', 'order' => 7],
            ['name' => 'Agrobiznes', 'icon' => '🌿', 'order' => 8],
            ['name' => 'Teknologji', 'icon' => '💻', 'order' => 9],
            ['name' => 'Produksion', 'icon' => '🏭', 'order' => 10],
        ];

        foreach ($industries as $item) {
            Industry::updateOrCreate(
                ['slug' => Str::slug($item['name'])],
                [
                    'name' => $item['name'],
                    'icon' => $item['icon'],
                    'sort_order' => $item['order'],
                ]
            );
        }
    }
}
