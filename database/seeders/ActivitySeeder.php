<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Activity::create([
            'user_id' => 1, // Assuming admin user ID is 1
            'type' => 'transaction',
            'description' => 'Transaksi baru INV-20260227-0001 sebesar Rp 150.000 telah selesai.',
        ]);
        
        \App\Models\Activity::create([
            'user_id' => 1,
            'type' => 'purchase',
            'description' => 'Restok barang dari Supplier Utama berhasil diterima.',
        ]);
        
        \App\Models\Activity::create([
            'user_id' => 1,
            'type' => 'debt',
            'description' => 'Pelanggan Budi telah melunasi piutang sebesar Rp 50.000.',
        ]);
    }
}
