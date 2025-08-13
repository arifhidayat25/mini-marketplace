<div>
    {{-- Kontainer utama untuk mengatur layout dan padding --}}
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8">

        <div class="mb-8">
            <livewire:hero-banner />
        </div>

        @if($promoProducts->isNotEmpty())
        <div class="mb-12">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-gray-800">Member baru? Ini promo!</h2>
                <a href="#" class="text-sm font-semibold text-indigo-600 hover:underline">Lihat Semua</a>
            </div>

            <div x-data="{
                init() {
                    setTimeout(() => {
                        new Swiper(this.$refs.promoSwiper, {
                            slidesPerView: 2.2,
                            spaceBetween: 16,
                            navigation: {
                                nextEl: '.swiper-button-next-promo',
                                prevEl: '.swiper-button-prev-promo',
                            },
                            breakpoints: {
                                640: { slidesPerView: 3 },
                                768: { slidesPerView: 4 },
                                1024: { slidesPerView: 5 },
                                1280: { slidesPerView: 6 },
                            }
                        });
                    }, 50);
                }
            }" x-init="init()" class="relative">
                <div x-ref="promoSwiper" class="swiper overflow-hidden">
                    <div class="swiper-wrapper">
    @foreach($promoProducts as $product)
    <div class="swiper-slide h-auto">
<a href="{{ route('product.detail', $product) }}" class="flex flex-col border rounded-lg overflow-hidden bg-white hover:shadow-md transition-shadow duration-300 h-full">            @if(Str::startsWith($product->image_url, 'http'))
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-40 object-cover">
            @else
                <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" class="w-full h-40 object-cover">
            @endif
            <div class="p-3 flex flex-col flex-grow">
                <p class="text-sm text-gray-800 truncate flex-grow" title="{{ $product->name }}">{{ $product->name }}</p>
                <p class="text-base font-bold text-gray-900 mt-1">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
            </div>
                    </a>
            </div>
            @endforeach
            </div>
                </div>

                <div class="swiper-button-prev swiper-button-prev-promo text-indigo-600 -left-2 md:-left-4 hidden md:flex after:text-2xl"></div>
                <div class="swiper-button-next swiper-button-next-promo text-indigo-600 -right-2 md:-right-4 hidden md:flex after:text-2xl"></div>
            </div>
        </div>
        @endif
        
        <h1 class="text-3xl font-bold mb-6">Produk</h1>
        
        
        <div>
            <div wire:loading class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @for ($i = 0; $i < 12; $i++)
                <div class="bg-white border rounded-lg shadow-sm overflow-hidden">
                    <div class="w-full h-48 bg-gray-200 animate-pulse"></div>
                    <div class="p-4">
                        <div class="h-6 w-3/4 bg-gray-200 rounded animate-pulse mb-2"></div>
                        <div class="h-4 w-1/2 bg-gray-200 rounded animate-pulse"></div>
                        <div class="mt-4 flex justify-between items-center">
                            <div class="h-8 w-1/3 bg-gray-200 rounded animate-pulse"></div>
                            <div class="h-8 w-1/4 bg-gray-200 rounded animate-pulse"></div>
                        </div>
                    </div>
                </div>
                @endfor
            </div>

            <div wire:loading.remove class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse ($products as $product)
                    {{-- 1. Kartu produk sekarang dibungkus dengan tag <a> --}}
                    <a href="{{ route('product.detail', $product) }}" wire:navigate class="block bg-white border rounded-lg shadow-sm overflow-hidden transition hover:shadow-lg">
                        @if(Str::startsWith($product->image_url, 'http'))
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                        @else
                            <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                        @endif
                        <div class="p-4">
                            <h2 class="text-lg font-semibold text-gray-800 truncate" title="{{ $product->name }}">{{ $product->name }}</h2>
                            <p class="text-sm text-gray-600 mt-1">{{ $product->category->name }}</p>
                            <p class="text-sm font-medium mt-2 @if($product->stock < 10) text-red-500 @else text-green-600 @endif">
                                Stok: {{ $product->stock }}
                            </p>
                            <div class="mt-4">
                                <span class="text-xl font-bold text-gray-900">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                            </div>
                            {{-- 2. Tombol "Detail" sudah dihapus karena tidak perlu lagi --}}
                        </div>
                    </a>
                @empty
                    <p class="col-span-full text-center text-gray-500 py-12">Tidak ada produk yang cocok dengan pencarian Anda.</p>
                @endforelse
            </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>

    </div>
</div>