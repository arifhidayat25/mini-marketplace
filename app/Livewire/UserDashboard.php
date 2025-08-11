<?php

namespace App\Livewire;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Dashboard Saya')]
class UserDashboard extends Component
{
    public $orders;
    public $totalSpent = 0;
    public $orderCount = 0;

    public function mount()
    {
        // Ambil ID pengguna yang sedang login
        $userId = Auth::id();

        // Ambil semua pesanan milik pengguna tersebut, urutkan dari yang terbaru
        $this->orders = Order::where('user_id', $userId)->latest()->get();

        // Hitung statistik ringkasan
        $this->orderCount = $this->orders->count();
        $this->totalSpent = $this->orders->sum('total_price');
    }

    public function render()
    {
        return view('livewire.user-dashboard');
    }
}