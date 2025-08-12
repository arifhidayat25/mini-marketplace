<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Peran (Roles) terlebih dahulu
        

        // 2. Buat pengguna "Penjual Utama" dan berikan peran 'seller'
        $seller = User::factory()->create([
            'name' => 'Penjual Utama',
            'email' => 'seller@example.com',
        ]);

        // 3. Buat pengguna "Test User" dan berikan peran 'buyer'
        $testUser = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        
        // 4. Buat kategori
        try {
            Category::factory(7)->create();
        } catch (\Exception $e) {
            // Abaikan error jika nama kategori unik sudah habis
        }
        $categories = Category::all();

        // 5. Buat 30 produk acak
        if ($categories->isNotEmpty()) {
            for ($i = 0; $i < 30; $i++) {
                Product::factory()->create([
                    'user_id' => $seller->id, // Semua produk dimiliki oleh Penjual Utama
                    'category_id' => $categories->random()->id, // Pilih ID kategori secara acak
                ]);
            }
        }
    }
}