<?php

namespace App\Providers\Filament;

// IMPORT SEMUA RESOURCE ANDA
use App\Filament\Resources\BannerResource;
use App\Filament\Resources\CategoryResource;
use App\Filament\Resources\ConversationResource;
use App\Filament\Resources\PesananResource;
use App\Filament\Resources\ProductResource;
// IMPORT WIDGET BARU ANDA
use App\Filament\Widgets\ProductsSoldWidget;
use App\Filament\Widgets\SalesStatsWidget;
use App\Filament\Widgets\StatsOverviewWidget;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors(['primary' => Color::Amber])
            ->pages([Pages\Dashboard::class])
            ->widgets([
                // DAFTARKAN SEMUA WIDGET DI SINI
                StatsOverviewWidget::class,
                SalesStatsWidget::class,
                ProductsSoldWidget::class,
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            // DAFTARKAN SEMUA RESOURCE DI SINI
            ->resources([
                BannerResource::class,
                CategoryResource::class,
                ProductResource::class,
                PesananResource::class,
                ConversationResource::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([Authenticate::class]);
    }
}
