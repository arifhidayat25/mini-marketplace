<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;

#[Layout('layouts.app')]
class SearchPage extends Component
{
    use WithPagination;

    #[Url(as: 'q', except: '')]
    public $search = '';

    public function render()
    {
        $products = Product::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(16);

        return view('livewire.search-page', [
            'products' => $products,
        ])->title('Hasil Pencarian untuk: ' . $this->search);
    }
}