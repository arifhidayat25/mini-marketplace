<?php

namespace App\Livewire;

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

    public function render()
    {
        return view('livewire.user-order-detail-page');
    }
}