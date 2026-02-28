<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class CategoryProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Makanan Pokok' => [
                ['name' => 'Beras Premium 5kg', 'buy_price' => 65000, 'sell_price' => 72000, 'stock' => 50, 'min_stock' => 10, 'unit' => 'karung'],
                ['name' => 'Minyak Goreng 1L', 'buy_price' => 14000, 'sell_price' => 16500, 'stock' => 100, 'min_stock' => 20, 'unit' => 'botol'],
                ['name' => 'Gula Pasir 1kg', 'buy_price' => 13500, 'sell_price' => 15000, 'stock' => 80, 'min_stock' => 15, 'unit' => 'bungkus'],
                ['name' => 'Telur Ayam 1kg', 'buy_price' => 24000, 'sell_price' => 27000, 'stock' => 30, 'min_stock' => 5, 'unit' => 'kg'],
                ['name' => 'Indomie Mie Goreng', 'buy_price' => 2800, 'sell_price' => 3500, 'stock' => 200, 'min_stock' => 40, 'unit' => 'pcs'],
            ],
            'Minuman' => [
                ['name' => 'Aqua 600ml', 'buy_price' => 3000, 'sell_price' => 4000, 'stock' => 120, 'min_stock' => 24, 'unit' => 'botol'],
                ['name' => 'Teh Botol Sosro 350ml', 'buy_price' => 4000, 'sell_price' => 5500, 'stock' => 60, 'min_stock' => 12, 'unit' => 'botol'],
                ['name' => 'Coca Cola 250ml', 'buy_price' => 4500, 'sell_price' => 6000, 'stock' => 48, 'min_stock' => 10, 'unit' => 'kaleng'],
                ['name' => 'Kopi Kapal Api 165g', 'buy_price' => 12000, 'sell_price' => 14500, 'stock' => 40, 'min_stock' => 8, 'unit' => 'bungkus'],
            ],
            'Snack & Cemilan' => [
                ['name' => 'Chitato Sapi Panggang', 'buy_price' => 8500, 'sell_price' => 10500, 'stock' => 30, 'min_stock' => 5, 'unit' => 'pcs'],
                ['name' => 'Silverqueen Almond', 'buy_price' => 12000, 'sell_price' => 15000, 'stock' => 25, 'min_stock' => 5, 'unit' => 'pcs'],
                ['name' => 'Oreo Original', 'buy_price' => 7000, 'sell_price' => 9000, 'stock' => 50, 'min_stock' => 10, 'unit' => 'pcs'],
            ],
            'Perlengkapan Rumah' => [
                ['name' => 'Rinso 770g', 'buy_price' => 22000, 'sell_price' => 26000, 'stock' => 20, 'min_stock' => 5, 'unit' => 'bungkus'],
                ['name' => 'Sunlight 210ml', 'buy_price' => 4500, 'sell_price' => 6000, 'stock' => 40, 'min_stock' => 8, 'unit' => 'pouch'],
                ['name' => 'Pepsodent 190g', 'buy_price' => 11000, 'sell_price' => 13500, 'stock' => 30, 'min_stock' => 6, 'unit' => 'pcs'],
            ],
            'Rokok' => [
                ['name' => 'Sampoerna Mild 16', 'buy_price' => 28000, 'sell_price' => 31000, 'stock' => 50, 'min_stock' => 10, 'unit' => 'bungkus'],
                ['name' => 'Gudang Garam Filter 12', 'buy_price' => 22000, 'sell_price' => 24500, 'stock' => 40, 'min_stock' => 8, 'unit' => 'bungkus'],
                ['name' => 'Marlboro Red', 'buy_price' => 35000, 'sell_price' => 39000, 'stock' => 20, 'min_stock' => 5, 'unit' => 'bungkus'],
            ],
        ];

        foreach ($categories as $categoryName => $products) {
            $category = Category::firstOrCreate(['name' => $categoryName]);

            foreach ($products as $productData) {
                Product::firstOrCreate(
                    ['name' => $productData['name']],
                    array_merge($productData, ['category_id' => $category->id])
                );
            }
        }
    }
}
