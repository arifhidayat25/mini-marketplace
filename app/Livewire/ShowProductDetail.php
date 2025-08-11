<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')] // <-- Gunakan layout utama kita
class ShowProductDetail extends Component
{
    /**
     * Menampung data produk yang akan ditampilkan.
     * Laravel akan otomatis mengisinya berkat Route Model Binding.
     */
    public Product $product;

    /**
     * Method mount akan menerima model Product yang sudah ditemukan oleh Laravel.
     */
    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function render()
    {
        return view('livewire.show-product-detail');
    }
    public function addToCart(Product $product)
{
    // --- BAGIAN BARU: VALIDASI STOK ---
    if ($product->stock <= 0) {
        session()->flash('error', 'Maaf, stok produk ini telah habis.');
        return; // Hentikan eksekusi method
    }
    // 1. Ambil keranjang yang ada dari session
    $cart = session()->get('cart', []);

    // 2. Cek apakah produk sudah ada di keranjang
    if(isset($cart[$product->id])) {
        // Jika sudah ada, tambah kuantitasnya
        $cart[$product->id]['quantity']++;
    } else {
        // Jika belum ada, tambahkan sebagai item baru
        $cart[$product->id] = [
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->price,
            "image_url" => $product->image_url
        ];
    }

    // 3. Simpan kembali keranjang ke session
    session()->put('cart', $cart);

    // 4. Kirim event bahwa keranjang telah diupdate
    $this->dispatch('cart-updated');

    // 5. Beri notifikasi (opsional)
    session()->flash('success', 'Produk berhasil ditambahkan ke keranjang!');
}
}