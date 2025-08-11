<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\ShowProducts;
use App\Livewire\ShowProductDetail; 
use App\Livewire\ShoppingCart; 
 use App\Livewire\CheckoutPage;
 use App\Livewire\UserDashboard;
 use App\Livewire\UserOrderDetailPage;
 use App\Livewire\ManageUserAddresses;






Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// ROUTE UNTUK PRODUK
Route::get('/', ShowProducts::class)->name('home');

 //Route baru untuk detail produk
 Route::get('/produk/{product:slug}', ShowProductDetail::class)->name('product.detail');

// use App\Livewire\ShoppingCart;
 Route::get('/keranjang', ShoppingCart::class)->name('cart.index');

 // Route untuk halaman checkout
 Route::get('/checkout', CheckoutPage::class)->name('checkout.index');

 // Route untuk halaman sukses setelah pemesanan
 Route::get('/order/success', function () {
    return view('order-success');
})->name('order.success');

// untuk dashboard pengguna
 Route::get('/akun/dashboard', UserDashboard::class)->name('akun.dashboard')->middleware('auth');

 // Route untuk detail pesanan pengguna
Route::get('/akun/pesanan/{order}', UserOrderDetailPage::class)->name('akun.order.detail')->middleware('auth');

// Route untuk mengelola alamat pengguna
 Route::get('/akun/alamat', ManageUserAddresses::class)->name('akun.alamat')->middleware('auth');