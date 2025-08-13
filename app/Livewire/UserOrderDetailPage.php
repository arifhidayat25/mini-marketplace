<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Pesanan; // Pastikan ini mengarah ke model yang benar
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Detail Pesanan')]
class UserOrderDetailPage extends Component
{
    public Pesanan $order;

    public function mount(Pesanan $order)
    {
        // Otorisasi! Periksa apakah pengguna yang login boleh melihat pesanan ini.
        // Jika tidak, Laravel akan otomatis menampilkan halaman 403 Forbidden.
        $this->authorize('view', $order);
        
        // Muat relasi orderItems agar bisa diakses di view.
        $this->order = $order->load('orderItems.product');
    }

    public function buyAgain($productId)
    {
        $product = Product::find($productId);
        if (!$product) {
            return;
        }

        // --- VALIDASI STOK ---
        if ($product->stock <= 0) {
            session()->flash('error', 'Maaf, stok produk ini telah habis.');
            return;
        }

        $cart = session()->get('cart', []);

        if(isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image_url" => $product->image_url
            ];
        }

        session()->put('cart', $cart);
        $this->dispatch('cart-updated');
        session()->flash('success', 'Produk berhasil ditambahkan kembali ke keranjang!');
    }


    public function render()
    {
        return view('livewire.user-order-detail-page');
    }
}