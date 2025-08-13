<?php

namespace App\Livewire;

use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Wishlist Saya')]
class WishlistPage extends Component
{
    use WithPagination;

    // Fungsi untuk menghapus item dari wishlist
    public function removeFromWishlist($productId)
    {
        Wishlist::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->delete();

        session()->flash('success', 'Produk telah dihapus dari wishlist.');
    }

    public function render()
    {
        // Ambil data wishlist milik pengguna yang sedang login, beserta data produknya
        $wishlistItems = Wishlist::where('user_id', Auth::id())
                                 ->with('product')
                                 ->latest()
                                 ->paginate(12);

        return view('livewire.wishlist-page', [
            'wishlistItems' => $wishlistItems
        ]);
    }
}
