<?php

namespace App\Filament\Widgets;

use App\Models\OrderItem;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProductsSoldWidget extends BaseWidget
{
    protected function getStats(): array
    {
        // Menghitung jumlah item produk yang terjual dari pesanan yang sudah selesai
        $productsSoldCount = OrderItem::whereHas('pesanan', function ($query) {
            $query->where('status', 'completed');
        })->sum('quantity');

        return [
            Stat::make('Produk Terjual', $productsSoldCount)
                ->description('Total item dari pesanan selesai')
                ->descriptionIcon('heroicon-m-cube')
                ->color('primary'),
        ];
    }
}
