<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Pesanan;
use App\Models\OrderItem; // <-- TAMBAHKAN INI
use App\Models\Review;    // <-- TAMBAHKAN INI
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Detail Pesanan')]
class UserOrderDetailPage extends Component
{
    public Pesanan $order;

    // Properti baru untuk modal ulasan
    public $showReviewModal = false;
    public $selectedOrderItem;
    public $rating = 5;
    public $comment = '';

    public function mount(Pesanan $order)
    {
        $this->authorize('view', $order);
        // Muat relasi orderItems beserta produk dan ulasan yang mungkin sudah ada
        $this->order = $order->load('orderItems.product', 'orderItems.review');
    }

    // Fungsi yang hilang: untuk membuka modal
    public function openReviewModal($orderItemId)
    {
        $this->selectedOrderItem = OrderItem::find($orderItemId);
        // Reset form setiap kali modal dibuka
        $this->rating = 5;
        $this->comment = '';
        $this->showReviewModal = true;
    }

    // Fungsi untuk menyimpan ulasan
    public function submitReview()
    {
        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Cek apakah sudah ada ulasan untuk item ini
        $existingReview = Review::where('order_item_id', $this->selectedOrderItem->id)->exists();
        if ($existingReview) {
            session()->flash('error', 'Anda sudah memberikan ulasan untuk produk ini.');
            $this->showReviewModal = false;
            return;
        }

        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $this->selectedOrderItem->product_id,
            'order_item_id' => $this->selectedOrderItem->id,
            'rating' => $this->rating,
            'comment' => $this->comment,
        ]);

        session()->flash('success', 'Terima kasih atas ulasan Anda!');
        $this->showReviewModal = false;
        
        // Muat ulang data pesanan untuk menampilkan status ulasan terbaru
        $this->order->load('orderItems.product', 'orderItems.review');
    }

    public function buyAgain($productId)
    {
        // ... (fungsi buyAgain Anda tetap sama)
        $product = Product::find($productId);
        if (!$product) {
            return;
        }

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