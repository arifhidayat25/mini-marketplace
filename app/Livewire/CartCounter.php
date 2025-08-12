<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On; // Import Atribut On

class CartCounter extends Component
{
    public $total = 0;

    // Listener yang akan "mendengar" event 'cart-updated'
    #[On('cart-updated')]
    public function updateTotal()
    {
        $cart = session()->get('cart', []);
        $this->total = count($cart);
    }

    // Method mount dijalankan saat komponen pertama kali dimuat
    public function mount()
    {
        $this->updateTotal();
    }

    public function render()
    {
        return view('livewire.cart-counter');
    }
    
}