<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Selamat Datang')]
class ShowProducts extends Component
{
    use WithPagination;

    // Hapus #[Url] dari $search agar tidak lagi terikat ke URL di halaman ini
    public $search = '';

    #[Url(as: 'kategori')]
    public $selectedCategory = null;

    #[Url(as: 'urutkan')]
    public $sort = 'latest';

    public $categories;
    public $promoProducts;

    public function mount()
    {
        $this->categories = Category::all();
        $this->promoProducts = Product::query()
                                    ->inRandomOrder()
                                    ->take(10)
                                    ->get();
    }

    public function render()
    {
        $productsQuery = Product::query();

        // LOGIKA PENCARIAN DI BAWAH INI SUDAH DIHAPUS
        // $productsQuery->when($this->search, ...);

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

        $products = $productsQuery->paginate(12);

        return view('livewire.show-products', [
            'products' => $products,
        ]);
    }
}