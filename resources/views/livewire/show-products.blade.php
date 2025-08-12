<div> <div class="mb-8">
        <livewire:hero-banner />
    </div>

    <div class="mb-8">
        <input 
            wire:model.live.debounce.300ms="search" 
            type="text" 
            placeholder="Cari produk impianmu..." 
            class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
        >
    </div>

    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <div class="flex flex-wrap gap-2">
            <button wire:click.prevent="$set('selectedCategory', null)" class="{{ is_null($selectedCategory) ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700' }} px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-500 hover:text-white transition">
                Semua Kategori
            </button>
            @foreach($categories as $category)
                <button wire:click.prevent="$set('selectedCategory', {{ $category->id }})" class="{{ $selectedCategory == $category->id ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700' }} px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-500 hover:text-white transition">
                    {{ $category->name }}
                </button>
            @endforeach
        </div>

        <div>
            <select wire:model.live="sort" class="border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="latest">Urutkan: Terbaru</option>
                <option value="cheapest">Urutkan: Termurah</option>
                <option value="expensive">Urutkan: Termahal</option>
            </select>
        </div>
    </div>

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
                <div class="bg-white border rounded-lg shadow-sm overflow-hidden transition hover:shadow-lg">
                    @if(Str::startsWith($product->image_url, 'http'))
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                    @else
                        <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                    @endif
                    <div class="p-4">
                        <h2 class="text-lg font-semibold text-gray-800 truncate">{{ $product->name }}</h2>
                        <p class="text-sm text-gray-600 mt-1">{{ $product->category->name }}</p>
                        <p class="text-sm font-medium @if($product->stock < 10) text-red-500 @else text-green-600 @endif">
                            Stok: {{ $product->stock }}
                        </p>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-xl font-bold text-gray-900">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                            <a href="{{ route('product.detail', $product) }}" wire:navigate class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-sm">
                                Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="col-span-full text-center text-gray-500 py-12">Tidak ada produk yang cocok dengan pencarian Anda.</p>
            @endforelse
        </div>
    </div>

    <div class="mt-8">
        {{ $products->links() }}
    </div>

</div>