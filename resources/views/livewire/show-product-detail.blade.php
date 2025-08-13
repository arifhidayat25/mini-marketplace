<div>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">

        @if (session()->has('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12">
            <div>
                <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" class="w-full h-auto rounded-lg shadow-lg object-cover border">
            </div>

            <div class="flex flex-col">
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 leading-tight">
                    {{ $product->name }}
                </h1>

                <div class="mt-2 flex items-center space-x-4 text-sm text-gray-500">
                    <span>Terjual 500+</span>
                    <span class="text-gray-300">|</span>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        @if($product->reviews->isNotEmpty())
                            <span class="ml-1 font-semibold">{{ number_format($product->reviews->avg('rating'), 1) }}</span>
                            <span class="ml-1 text-gray-500">({{ $product->reviews->count() }} ulasan)</span>
                        @else
                            <span class="ml-1">Belum ada ulasan</span>
                        @endif
                    </div>
                </div>

                <p class="mt-4 text-3xl font-bold text-indigo-700">
                    Rp{{ number_format($product->price, 0, ',', '.') }}
                </p>

                <div class="mt-6 border-t pt-6">
                    <h2 class="text-lg font-semibold text-gray-800">Deskripsi</h2>
                    <p class="mt-2 text-gray-600 leading-relaxed">
                        {{ $product->description }}
                    </p>
                </div>
                
                <div class="mt-6 text-sm text-gray-500">
                    <span>Dijual oleh: <a href="#" class="text-indigo-600 hover:underline">{{ $product->user->name }}</a></span>
                    <span class="mx-2">|</span>
                    <span>Kategori: <a href="{{ route('category.show', $product->category) }}" class="text-indigo-600 hover:underline">{{ $product->category->name }}</a></span>
                </div>

                <div class="mt-auto pt-6">
                    <div class="flex items-center space-x-4">
                        @if ($product->stock > 0)
                            <div class="flex items-center border border-gray-300 rounded-lg">
                                <button wire:click="decreaseQuantity" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-l-lg">-</button>
                                <span class="px-5 py-2 font-semibold">{{ $quantity }}</span>
                                <button wire:click="increaseQuantity" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-r-lg">+</button>
                            </div>

                            <button wire:click="addToCart({{ $product->id }})" class="flex-1 w-full bg-indigo-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-indigo-700 transition duration-300">
                                + Tambah ke Keranjang
                            </button>
                        @else
                            <button disabled class="flex-1 w-full bg-gray-400 text-white font-bold py-3 px-6 rounded-lg cursor-not-allowed">
                                Stok Habis
                            </button>
                        @endif

                        {{-- Tombol Wishlist --}}
                        <button wire:click="toggleWishlist" class="p-3 border rounded-lg hover:bg-gray-100 transition {{ $isInWishlist ? 'text-red-500' : 'text-gray-500' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="{{ $isInWishlist ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>
                    </div>
                    @if($product->stock > 0)
                        <p class="text-right text-gray-600 mt-2">Stok: {{ $product->stock }}</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Bagian Ulasan Produk --}}
        <div class="mt-16 border-t pt-10">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Ulasan Produk</h2>
            @if($product->reviews->isNotEmpty())
                <div class="space-y-8">
                    @foreach($product->reviews as $review)
                        <div class="flex items-start space-x-4">
                            <img src="{{ $review->user->profile_photo_url }}" alt="{{ $review->user->name }}" class="size-12 rounded-full object-cover">
                            <div>
                                <div class="flex items-center space-x-2">
                                    <p class="font-semibold">{{ $review->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $review->created_at->format('d M Y') }}</p>
                                </div>
                                <div class="flex items-center mt-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    @endfor
                                </div>
                                @if($review->comment)
                                    <p class="text-gray-600 mt-2">{{ $review->comment }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 bg-gray-50 rounded-lg">
                    <p class="text-gray-500">Belum ada ulasan untuk produk ini.</p>
                </div>
            @endif
        </div>

        {{-- Produk Serupa --}}
        <div class="mt-16 border-t pt-10">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Produk Serupa</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                 @forelse ($relatedProducts as $related)
                    <div class="bg-white border rounded-lg shadow-sm overflow-hidden transition hover:shadow-lg">
                        <a href="{{ route('product.detail', $related) }}" wire:navigate>
                            <img src="{{ asset('storage/' . $related->image_url) }}" alt="{{ $related->name }}" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-800 truncate">{{ $related->name }}</h3>
                                <p class="mt-2 text-xl font-bold text-gray-900">Rp{{ number_format($related->price, 0, ',', '.') }}</span>
                            </div>
                        </a>
                    </div>
                @empty
                    <p class="col-span-full text-center text-gray-500">Tidak ada produk serupa.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>