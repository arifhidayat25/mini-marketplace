<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true), // Menghasilkan 3 kata acak
            'description' => $this->faker->paragraph(3), // Menghasilkan 3 kalimat paragraf
            'price' => $this->faker->numberBetween(50000, 5000000), // Harga antara 50rb - 5jt
            'stock' => $this->faker->numberBetween(5, 100), // Stok antara 5 - 100
            'image_url' => 'https://placehold.co/640x480/E2E8F0/4A5568?text=' . urlencode($this->faker->words(2, true)),
        ];
    }
}