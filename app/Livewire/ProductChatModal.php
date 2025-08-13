<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class ProductChatModal extends Component
{
    public ?Product $product = null;
    public $conversation;
    // public $messages; // Properti ini dihapus karena menyebabkan error
    public $body;
    public $isOpen = false;

    #[On('open-chat-modal')]
    public function openModal($productId) // Menerima ID produk, bukan objek
    {
        if (!Auth::check()) {
            return $this->redirect(route('login'));
        }

        $this->product = Product::find($productId);
        if (!$this->product) return;

        $this->isOpen = true;
        $this->loadConversation();
    }

    public function addToCart()
    {
        if (!$this->product) {
            return;
        }

        if ($this->product->stock <= 0) {
            session()->flash('error', 'Maaf, stok produk ini telah habis.');
            return;
        }

        $cart = session()->get('cart', []);
        $quantityToAdd = 1; // Selalu tambah 1 dari chat

        if(isset($cart[$this->product->id])) {
            if ($this->product->stock >= ($cart[$this->product->id]['quantity'] + $quantityToAdd)) {
                $cart[$this->product->id]['quantity'] += $quantityToAdd;
            } else {
                session()->flash('error', 'Maaf, jumlah item di keranjang melebihi stok yang tersedia.');
                return;
            }
        } else {
            $cart[$this->product->id] = [
                "name" => $this->product->name,
                "quantity" => $quantityToAdd,
                "price" => $this->product->price,
                "image_url" => $this->product->image_url
            ];
        }

        session()->put('cart', $cart);
        $this->dispatch('cart-updated'); // Update ikon keranjang
        
        // Beri notifikasi di halaman berikutnya
        session()->flash('success', 'Produk berhasil ditambahkan ke keranjang!');

        // Tutup modal setelah berhasil ditambahkan
        $this->closeModal();
    }

    public function loadConversation()
    {
        $this->conversation = Conversation::firstOrCreate([
            'user_id' => Auth::id(),
            'product_id' => $this->product->id,
        ]);

        // Tandai pesan dari admin sebagai sudah dibaca
        $this->conversation->messages()->whereNull('user_id')->update(['read_at' => now()]);
    }

    public function sendMessage()
    {
        $this->validate(['body' => 'required']);

        if (!$this->conversation) {
            $this->loadConversation();
        }

        $this->conversation->messages()->create([
            'user_id' => Auth::id(),
            'body' => $this->body,
        ]);

        $this->reset('body');
        $this->dispatch('refreshInbox');

    }
    
    public function closeModal()
    {
        $this->isOpen = false;
        $this->reset('product', 'conversation', 'body'); // Bersihkan state saat ditutup
    }

    public function render()
    {
        $messages = collect(); // Default ke koleksi kosong
        if ($this->isOpen && $this->conversation) {
            // Muat pesan di sini, bukan di properti publik
            $messages = $this->conversation->messages()->get();
        }

        return view('livewire.product-chat-modal', [
            'messages' => $messages
        ]);
    }

    
}