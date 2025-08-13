<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Wishlist Saya</h1>

    @if (session()->has('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if($wishlistItems->isNotEmpty())
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($wishlistItems as $item)
                @if($item->product) {{-- Pastikan produk masih ada --}}
                <div class="bg-white border rounded-lg shadow-sm overflow-hidden group">
                    <a href="{{ route('product.detail', $item->product) }}" wire:navigate class="block">
                        <img src="{{ asset('storage/' . $item->product->image_url) }}" alt="{{ $item->product->name }}" class="w-full h-48 object-cover">
                    </a>
                    <div class="p-4">
                        <a href="{{ route('product.detail', $item->product) }}" wire:navigate>
                            <h2 class="text-lg font-semibold text-gray-800 truncate" title="{{ $item->product->name }}">{{ $item->product->name }}</h2>
                        </a>
                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-xl font-bold text-gray-900">Rp{{ number_format($item->product->price, 0, ',', '.') }}</span>
                            <button 
                                wire:click="removeFromWishlist({{ $item->product->id }})"
                                wire:confirm="Anda yakin ingin menghapus produk ini dari wishlist?"
                                class="text-red-500 opacity-0 group-hover:opacity-100 transition-opacity" 
                                title="Hapus dari wishlist">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>

        <div class="mt-8">
            {{ $wishlistItems->links() }}
        </div>
    @else
        <div class="bg-white p-12 rounded-lg shadow-md text-center">
            <h2 class="text-2xl font-semibold text-gray-700 mb-2">Wishlist Anda Kosong</h2>
            <p class="text-gray-500 mb-6">Simpan produk yang Anda sukai agar tidak lupa.</p>
            <a href="{{ route('home') }}" wire:navigate class="inline-block bg-indigo-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-indigo-700">
                Mulai Belanja
            </a>
        </div>
    @endif
</div>
