<?php

namespace App\Livewire;

use App\Models\Product; // Import model Product
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class ShoppingCart extends Component
{
    public $cartItems = [];
    public $totalPrice = 0;

    public function mount()
    {
        $this->updateCart();
    }

    public function updateCart()
    {
        $this->cartItems = session()->get('cart', []);
        $this->totalPrice = 0;
        foreach ($this->cartItems as $item) {
            $this->totalPrice += $item['price'] * $item['quantity'];
        }
    }

    public function removeFromCart($productId)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$productId])) {
            unset($cart[$productId]);
        }
        session()->put('cart', $cart);

        $this->dispatch('cart-updated');
        $this->updateCart();
    }

    // FUNGSI BARU: Menambah jumlah barang
    public function increaseQuantity($productId)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$productId])) {
            // Cek stok produk
            $product = Product::find($productId);
            if ($product->stock > $cart[$productId]['quantity']) {
                $cart[$productId]['quantity']++;
            } else {
                session()->flash('error', 'Stok produk ' . $product->name . ' tidak mencukupi.');
            }
        }
        session()->put('cart', $cart);
        $this->dispatch('cart-updated');
        $this->updateCart();
    }

    // FUNGSI BARU: Mengurangi jumlah barang
    public function decreaseQuantity($productId)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$productId]) && $cart[$productId]['quantity'] > 1) {
            $cart[$productId]['quantity']--;
        }
        session()->put('cart', $cart);
        $this->dispatch('cart-updated');
        $this->updateCart();
    }


    public function render()
    {
        return view('livewire.shopping-cart');
    }
}