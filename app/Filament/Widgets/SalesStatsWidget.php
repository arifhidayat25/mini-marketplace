<?php

namespace App\Filament\Widgets;

use App\Models\Pesanan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SalesStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        // Menghitung total pendapatan hanya dari pesanan yang statusnya 'completed'
        $totalSales = Pesanan::where('status', 'completed')->sum('total_price');

        return [
            Stat::make('Total Penjualan', 'Rp' . number_format($totalSales, 0, ',', '.'))
                ->description('Pendapatan dari pesanan selesai')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('info'),
        ];
    }
}
