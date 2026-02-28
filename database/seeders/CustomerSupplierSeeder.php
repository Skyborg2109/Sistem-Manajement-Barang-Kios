<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class CustomerSupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            ['name' => 'Budi Santoso', 'phone' => '081234567891'],
            ['name' => 'Ani Wijaya', 'phone' => '081234567892'],
            ['name' => 'Siti Aminah', 'phone' => '081234567893'],
            ['name' => 'Wawan Kurniawan', 'phone' => '081234567894'],
        ];

        foreach ($customers as $customer) {
            Customer::firstOrCreate(['phone' => $customer['phone']], $customer);
        }

        $suppliers = [
            ['name' => 'CV Maju Jaya', 'phone' => '0215551234'],
            ['name' => 'PT Sumber Rejeki', 'phone' => '0215555678'],
            ['name' => 'Gudang Sembako Pusat', 'phone' => '0215559012'],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::firstOrCreate(['name' => $supplier['name']], $supplier);
        }
    }
}
