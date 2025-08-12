<?php

namespace App\Notifications;

use App\Models\Order; // <-- 1. Import model Order
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusUpdated extends Notification
{
    use Queueable;

    public $order; // Properti untuk menampung data pesanan

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        // Saat notifikasi dibuat, kita terima data pesanan
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // Kita akan mengirim notifikasi ini ke 'database'
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        // Ini adalah format data yang akan disimpan di kolom 'data'
        return [
            'order_id' => $this->order->id,
            'title' => 'Status Pesanan Diperbarui!',
            'message' => "Kabar baik! Status pesanan Anda telah diubah menjadi '{$this->order->status}'.",
            'link' => route('akun.order.detail', $this->order->id),
        ];
    }
}