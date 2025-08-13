<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class CategoryPage extends Component
{
    use WithPagination;

    public Category $category;

    public function mount(Category $category)
    {
        $this->category = $category;
    }

    public function render()
    {
        $products = Product::where('category_id', $this->category->id)
                            ->latest()
                            ->paginate(12);

        // Ini adalah cara yang benar untuk mengatur judul halaman secara dinamis
        return view('livewire.category-page', [
            'products' => $products,
        ])->title('Kategori: ' . $this->category->name);
    }
}