<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'store_name', 'value' => 'Toko Kelontong Sejahtera'],
            ['key' => 'store_address', 'value' => 'Jl. Pasar Baru No. 123, Jakarta'],
            ['key' => 'store_phone', 'value' => '021-5551234'],
            ['key' => 'store_email', 'value' => 'info@tokokelontong.com'],
            ['key' => 'low_stock_threshold', 'value' => '10'],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
