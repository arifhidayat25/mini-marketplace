<?php

namespace App\Filament\Resources\PesananResource\Pages;

use App\Filament\Resources\PesananResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Notifications\OrderStatusUpdated; // <-- 1. Tambahkan use statement ini

class EditPesanan extends EditRecord
{
    protected static string $resource = PesananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    // 2. Tambahkan method afterSave() di bawah ini
    protected function afterSave(): void
    {
        // Ambil data pesanan yang baru saja di-update
        $order = $this->record;

        // Ambil data user yang memiliki pesanan ini
        $user = $order->user;

        // Kirim notifikasi ke user jika user-nya ada
        if ($user) {
            $user->notify(new OrderStatusUpdated($order));
        }
    }
}