<?php

namespace App\Livewire;

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
        $this->updateCart(); // Update tampilan komponen ini
    }

    public function render()
    {
        return view('livewire.shopping-cart');
    }
}