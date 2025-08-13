<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
    {{-- Header Halaman Pencarian --}}
    <div class="pb-6 border-b border-gray-200 mb-8">
        <h1 class="text-3xl font-bold text-gray-800">
            Hasil Pencarian untuk: <span class="text-indigo-600">"{{ $search }}"</span>
        </h1>
        <p class="mt-2 text-gray-600">{{ $products->total() }} produk ditemukan.</p>
    </div>

    @if($products->isNotEmpty())
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($products as $product)
                <a href="{{ route('product.detail', $product) }}" class="block bg-white border rounded-lg shadow-sm overflow-hidden transition hover:shadow-lg">
                    <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h2 class="text-lg font-semibold text-gray-800 truncate" title="{{ $product->name }}">{{ $product->name }}</h2>
                        <p class="text-sm text-gray-600 mt-1">Stok: {{ $product->stock }}</p>
                        <div class="mt-4">
                            <span class="text-xl font-bold text-gray-900">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>
    @else
        <div class="text-center py-16 bg-white rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold text-gray-700">Oops!</h2>
            <p class="text-gray-500 mt-2">Produk yang Anda cari tidak ditemukan.</p>
        </div>
    @endif
</div>