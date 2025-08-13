<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Keranjang Belanja Anda</h1>

    @if (session()->has('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    @if (empty($cartItems))
        <div class="bg-white p-12 rounded-lg shadow-md text-center">
            <h2 class="text-2xl font-semibold text-gray-700 mb-2">Keranjang Anda Kosong</h2>
            <p class="text-gray-500 mb-6">Sepertinya Anda belum menambahkan produk apapun.</p>
            <a href="{{ route('home') }}" wire:navigate class="inline-block bg-indigo-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-indigo-700">
                Mulai Belanja
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 bg-white shadow-md rounded-lg p-6">
                @foreach($cartItems as $id => $item)
                <div class="flex flex-col sm:flex-row items-center justify-between py-4 {{ !$loop->last ? 'border-b border-gray-200' : '' }}">
                    <div class="flex items-center space-x-4 mb-4 sm:mb-0 w-full sm:w-1/2">
                        <img src="{{ asset('storage/' . $item['image_url']) }}" alt="{{ $item['name'] }}" class="w-20 h-20 rounded object-cover border">
                        <div>
                            <p class="font-semibold text-gray-800">{{ $item['name'] }}</p>
                            <p class="text-sm text-gray-600">Rp{{ number_format($item['price'], 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-6">
                        <div class="flex items-center border border-gray-300 rounded-md">
                            <button wire:click="decreaseQuantity({{ $id }})" class="px-3 py-1 text-gray-600 hover:bg-gray-100">-</button>
                            <span class="px-4 py-1">{{ $item['quantity'] }}</span>
                            <button wire:click="increaseQuantity({{ $id }})" class="px-3 py-1 text-gray-600 hover:bg-gray-100">+</button>
                        </div>

                        <p class="font-semibold w-24 text-right">Rp{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</p>

                        <button wire:click="removeFromCart({{ $id }})" class="text-red-500 hover:text-red-700" title="Hapus item">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </div>
                @endforeach
                 <div class="mt-6 text-left">
                    <a href="{{ route('home') }}" wire:navigate class="text-sm font-semibold text-indigo-600 hover:underline">
                        &larr; Lanjutkan Belanja
                    </a>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-white shadow-md rounded-lg p-6 sticky top-24">
                    <h2 class="text-xl font-bold mb-4">Ringkasan Belanja</h2>
                    <div class="flex justify-between mb-2 text-gray-600">
                        <span>Subtotal</span>
                        <span>Rp{{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between mb-4 text-gray-600">
                        <span>Pengiriman</span>
                        <span>Gratis</span>
                    </div>
                    <div class="border-t border-gray-200 pt-4 flex justify-between font-bold text-xl">
                        <span>Total</span>
                        <span>Rp{{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>
                    <a href="{{ route('checkout.index') }}" wire:navigate class="mt-6 w-full text-center inline-block bg-green-500 text-white font-bold py-3 px-6 rounded-lg hover:bg-green-600">
                        Lanjut ke Checkout
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>