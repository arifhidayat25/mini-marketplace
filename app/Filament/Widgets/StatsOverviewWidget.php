<?php

namespace App\Filament\Widgets;

use App\Models\Pesanan;
use App\Models\Product;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Pengguna', User::count())
                ->description('Jumlah seluruh pengguna terdaftar')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),
            Stat::make('Total Produk', Product::count())
                ->description('Jumlah produk di marketplace')
                ->descriptionIcon('heroicon-m-archive-box')
                ->color('warning'),
            Stat::make('Pesanan Baru', Pesanan::where('status', 'pending')->count())
                ->description('Pesanan yang perlu diproses')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('danger'),
        ];
    }
}
