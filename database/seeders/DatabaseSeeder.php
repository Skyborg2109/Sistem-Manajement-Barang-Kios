<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@kios.com'],
            [
                'name' => 'Admin Kios',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'kasir@kios.com'],
            [
                'name' => 'Kasir Kios',
                'password' => bcrypt('password'),
                'role' => 'kasir',
            ]
        );

        $this->call([
            CategoryProductSeeder::class,
            CustomerSupplierSeeder::class,
            ActivitySeeder::class,
            SettingSeeder::class,
        ]);
    }
}
