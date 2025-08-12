<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Order; // <-- Tambahkan ini
use App\Policies\OrderPolicy; // <-- Tambahkan ini
use Illuminate\Support\Facades\Gate; // <-- Import Gate


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    protected $policies = [
        Order::class => OrderPolicy::class, // <-- Tambahkan baris ini
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
        Gate::policy(Order::class, OrderPolicy::class);

    }
}
