<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class ShowProductDetail extends Component
{
    public Product $product;
    public $quantity = 1; // 1. Tambahkan properti untuk jumlah

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    // 2. Fungsi untuk mengurangi jumlah
    public function decreaseQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    // 3. Fungsi untuk menambah jumlah
    public function increaseQuantity()
    {
        if ($this->product->stock > $this->quantity) {
            $this->quantity++;
        }
    }


    public function addToCart(Product $product)
    {
        if ($product->stock < $this->quantity) {
            session()->flash('error', 'Maaf, stok produk tidak mencukupi.');
            return;
        }

        $cart = session()->get('cart', []);

        if(isset($cart[$product->id])) {
            // Cek apakah penambahan melebihi stok
            if ($product->stock >= ($cart[$product->id]['quantity'] + $this->quantity)) {
                $cart[$product->id]['quantity'] += $this->quantity;
            } else {
                session()->flash('error', 'Maaf, jumlah item di keranjang melebihi stok yang tersedia.');
                return;
            }
        } else {
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => $this->quantity,
                "price" => $product->price,
                "image_url" => $product->image_url
            ];
        }

        session()->put('cart', $cart);
        $this->dispatch('cart-updated');
        session()->flash('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function render()
    {
        // Ambil produk serupa berdasarkan kategori (kecuali produk ini sendiri)
        $relatedProducts = Product::where('category_id', $this->product->category_id)
                                ->where('id', '!=', $this->product->id)
                                ->inRandomOrder()
                                ->take(4)
                                ->get();

        return view('livewire.show-product-detail', [
            'relatedProducts' => $relatedProducts
        ]);
    }
}