<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ChatInbox extends Component
{
    public $conversations;
    public $unreadCount = 0;

    protected $listeners = ['refreshInbox' => '$refresh'];

    public function mount()
    {
        $this->loadConversations();
    }

    public function loadConversations()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $this->conversations = $user->conversations()
                                        ->with('product') // Muat info produk
                                        ->latest('updated_at')
                                        ->get();
            
            // Hitung pesan belum dibaca
            $this->unreadCount = $user->conversations()
                                   ->whereHas('messages', function ($query) {
                                       $query->whereNull('user_id')->whereNull('read_at');
                                   })->count();
        }
    }
    
    // Fungsi untuk membuka chat dari inbox
    public function openChat($productId)
    {
        // Kirim event ke modal chat untuk membuka dirinya dengan produk yang benar
        $this->dispatch('open-chat-modal', productId: $productId);
    }

    public function render()
    {
        // Panggil ulang untuk memastikan data selalu fresh
        $this->loadConversations();
        return view('livewire.chat-inbox');
    }
}