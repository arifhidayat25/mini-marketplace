<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Policy; // <-- Tambahkan ini
use App\Policies\PesananPolicy; // <-- Tambahkan ini
use Illuminate\Support\Facades\Gate; // <-- Import Gate


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    protected $policies = [
        Pesanan::class => PesananPolicy::class, // <-- Tambahkan baris ini
    ];
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Gate::policy(Pesanan::class, PesananPolicy::class);

    }
}
