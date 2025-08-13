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