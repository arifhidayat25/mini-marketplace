<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class ShowProductDetail extends Component
{
    public Product $product;
    public $quantity = 1;
    public $isInWishlist = false; // Properti untuk status wishlist

    public function mount(Product $product)
    {
        // Muat data produk beserta relasi ulasan dan data user yang memberikan ulasan
        $this->product = $product->load('reviews.user');

        // Cek apakah produk ada di wishlist user yang sedang login
        if (Auth::check()) {
            $this->isInWishlist = Wishlist::where('user_id', Auth::id())
                                          ->where('product_id', $this->product->id)
                                          ->exists();
        }
    }

    // Fungsi untuk mengurangi jumlah
    public function decreaseQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    // Fungsi untuk menambah jumlah
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

    // Fungsi untuk menambah/menghapus dari wishlist
    public function toggleWishlist()
    {
        if (!Auth::check()) {
            // Arahkan ke halaman login jika pengguna belum masuk
            return $this->redirect(route('login'));
        }

        $wishlistItem = Wishlist::where('user_id', Auth::id())
                                ->where('product_id', $this->product->id)
                                ->first();

        if ($wishlistItem) {
            // Jika sudah ada, hapus
            $wishlistItem->delete();
            $this->isInWishlist = false;
            session()->flash('success', 'Produk dihapus dari wishlist.');
        } else {
            // Jika belum ada, tambahkan
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $this->product->id,
            ]);
            $this->isInWishlist = true;
            session()->flash('success', 'Produk ditambahkan ke wishlist.');
        }
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