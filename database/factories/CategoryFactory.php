<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Daftar nama kategori yang realistis
        $categories = ['Elektronik', 'Pakaian Pria', 'Pakaian Wanita', 'Buku & Majalah', 'Olahraga', 'Otomotif', 'Kesehatan'];
        
        return [
            // Pilih satu nama secara acak dari daftar di atas
            'name' => $this->faker->unique()->randomElement($categories),
            // Slug akan dibuat otomatis oleh model event yang sudah kita buat
        ];
    }
}