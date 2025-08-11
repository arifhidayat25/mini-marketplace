<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\WithPagination; // <-- 1. Import WithPagination


#[Layout('layouts.app')]
#[Title('Selamat Datang')]
class ShowProducts extends Component
{
    use WithPagination; // <-- 2. Gunakan Trait WithPagination

    #[Url(as: 'q', except: '')]
    public $search = '';

    #[Url(as: 'kategori')]
    public $selectedCategory = null;

    #[Url(as: 'urutkan')]
    public $sort = 'latest';

    public $categories;

    public function mount()
    {
        $this->categories = Category::all();
    }

    public function render()
    {
        $productsQuery = Product::query();

        $productsQuery->when($this->search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%')
                         ->orWhere('description', 'like', '%' . $search . '%');
        });

        $productsQuery->when($this->selectedCategory, function ($query, $categoryId) {
            return $query->where('category_id', $categoryId);
        });

        if ($this->sort === 'cheapest') {
            $productsQuery->orderBy('price', 'asc');
        } elseif ($this->sort === 'expensive') {
            $productsQuery->orderBy('price', 'desc');
        } else {
            $productsQuery->orderBy('created_at', 'desc');
        }

        $products = $productsQuery->paginate(12); // Tampilkan 12 produk per halaman

        return view('livewire.show-products', [
            'products' => $products,
        ]);
    }
}