<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\ShowProducts;
use App\Livewire\ShowProductDetail;
use App\Livewire\ShoppingCart;
use App\Livewire\CheckoutPage;
use App\Livewire\UserDashboard;
use App\Livewire\UserOrderDetailPage;
use App\Livewire\ManageUserAddresses;
use App\Livewire\CategoryPage;
use App\Livewire\SearchPage; 
use App\Livewire\SearchBar;
use App\Livewire\WishlistPage;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// --- HALAMAN UTAMA & PRODUK ---
Route::get('/', ShowProducts::class)->name('home');
Route::get('/produk/{product:slug}', ShowProductDetail::class)->name('product.detail');
Route::get('/kategori/{category:slug}', CategoryPage::class)->name('category.show');
Route::get('/cari', SearchPage::class)->name('search.page');
Route::get('/cari-bar', SearchBar::class)->name('search.bar'); // Tambahkan route untuk SearchBar


// --- PROSES PEMBELIAN ---
Route::get('/keranjang', ShoppingCart::class)->name('cart.index');
Route::get('/checkout', CheckoutPage::class)->name('checkout.index');
Route::get('/order/success', function () {
    return view('order-success');
})->name('order.success');


// --- HALAMAN PENGGUNA (DENGAN OTENTIKASI) ---
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/akun/dashboard', UserDashboard::class)->name('akun.dashboard');
    Route::get('/akun/pesanan/{order}', UserOrderDetailPage::class)->name('akun.order.detail');
    Route::get('/akun/alamat', ManageUserAddresses::class)->name('akun.alamat');
    
    Route::get('/akun/wishlist', WishlistPage::class)->name('akun.wishlist');
});