<div class="container mx-auto ...">
    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12">
        <div>
            <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" class="w-full h-auto rounded-lg shadow-lg object-cover">
        </div>

        <div class="flex flex-col">
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 leading-tight">
                {{ $product->name }}
            </h1>

            <div class="mt-2 text-sm text-gray-500">
                <span>Dijual oleh: <a href="#" class="text-indigo-600 hover:underline">{{ $product->user->name }}</a></span>
                <span class="mx-2">|</span>
                <span>Kategori: <a href="#" class="text-indigo-600 hover:underline">{{ $product->category->name }}</a></span>
            </div>

            <p class="mt-4 text-3xl font-bold text-indigo-700">
                Rp{{ number_format($product->price, 0, ',', '.') }}
            </p>

            <div class="mt-6">
                <h2 class="text-lg font-semibold text-gray-800">Deskripsi</h2>
                <p class="mt-2 text-gray-600 leading-relaxed">
                    {{ $product->description }}
                </p>
            </div>

            <div class="mt-auto pt-6">
    <div class="flex items-center space-x-4">
        @if ($product->stock > 0)
            <button wire:click="addToCart({{ $product->id }})" class="w-full bg-indigo-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-indigo-700 transition duration-300 ease-in-out transform hover:scale-105">
                + Tambah ke Keranjang
            </button>
        @else
            <button disabled class="w-full bg-gray-400 text-white font-bold py-3 px-6 rounded-lg cursor-not-allowed">
                Stok Habis
            </button>
        @endif
        <span class="text-gray-600">Stok: {{ $product->stock }}</span>
    </div>
</div>
        </div>
    </div>
</div>