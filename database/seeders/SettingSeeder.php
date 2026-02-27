<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'shop_name',
                'label' => 'Nama Kios',
                'value' => 'M-KIOS',
                'type' => 'text',
                'group' => 'general',
            ],
            [
                'key' => 'shop_address',
                'label' => 'Alamat',
                'value' => 'Jl. Merdeka No. 123',
                'type' => 'textarea',
                'group' => 'general',
            ],
            [
                'key' => 'shop_phone',
                'label' => 'No. Telepon',
                'value' => '081234567890',
                'type' => 'text',
                'group' => 'general',
            ],
            [
                'key' => 'currency_symbol',
                'label' => 'Simbol Mata Uang',
                'value' => 'Rp',
                'type' => 'text',
                'group' => 'general',
            ],
        ];

        foreach ($settings as $setting) {
            \App\Models\Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
