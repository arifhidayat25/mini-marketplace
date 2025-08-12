<?php

namespace App\Providers\Filament;

<<<<<<< HEAD
// 1. IMPORT SEMUA RESOURCE ANDA DI SINI
use App\Filament\Resources\BannerResource;
use App\Filament\Resources\CategoryResource;
use App\Filament\Resources\OrderResource;
use App\Filament\Resources\PesananResource;
=======
// IMPORT SEMUA RESOURCE ANDA
use App\Filament\Resources\BannerResource;
use App\Filament\Resources\CategoryResource;
use App\Filament\Resources\OrderResource;
>>>>>>> 590bdcf86ab244b0468749af3c1829fa16156fbc
use App\Filament\Resources\ProductResource;

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
<<<<<<< HEAD
            ->colors([
                'primary' => Color::Amber,
            ])
            // discoverResources(...) akan kita ganti dengan pendaftaran manual
            ->pages([
                Pages\Dashboard::class,
            ])
=======
            ->colors(['primary' => Color::Amber])
            ->pages([Pages\Dashboard::class])
>>>>>>> 590bdcf86ab244b0468749af3c1829fa16156fbc
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
<<<<<<< HEAD
            // 2. TAMBAHKAN BLOK BARU DI BAWAH INI
            ->resources([
                BannerResource::class,
                CategoryResource::class,
                ProductResource::class,
                PesananResource::class,
=======
            // DAFTARKAN RESOURCE SECARA MANUAL DI SINI
            ->resources([
                BannerResource::class,
                CategoryResource::class,
                ProductResource::class,
>>>>>>> 590bdcf86ab244b0468749af3c1829fa16156fbc
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
<<<<<<< HEAD
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
=======
            ->authMiddleware([Authenticate::class]);
    }
}
>>>>>>> 590bdcf86ab244b0468749af3c1829fa16156fbc
