<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationIndicator extends Component
{
    public $unreadCount = 0;
    public $notifications = [];

    // Method ini dijalankan saat komponen dimuat
    public function mount()
    {
        $this->loadNotifications();
    }

    // Mengambil data notifikasi dari database
    public function loadNotifications()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $this->unreadCount = $user->unreadNotifications()->count();
            // Ambil 5 notifikasi terbaru untuk ditampilkan di dropdown
            $this->notifications = $user->notifications()->latest()->take(5)->get();
        }
    }

    /**
     * Menandai notifikasi sebagai sudah dibaca DAN mengarahkan ke link-nya.
     */
    public function markAsRead($notificationId)
    {
        if (Auth::check()) {
            $notification = Auth::user()->notifications()->find($notificationId);
            if ($notification) {
                // Tandai sudah dibaca
                $notification->markAsRead();

                // Jika notifikasi punya link, redirect ke sana
                if (isset($notification->data['link'])) {
                    // Redirect menggunakan fitur navigasi SPA dari Livewire
                    return $this->redirect($notification->data['link'], navigate: true);
                }
            }
            // Jika tidak ada link, cukup muat ulang notifikasi
            $this->loadNotifications();
        }
    }

    public function render()
    {
        return view('livewire.notification-indicator');
    }
}