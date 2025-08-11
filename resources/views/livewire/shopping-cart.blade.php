<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Keranjang Belanja Anda</h1>

    @if (empty($cartItems))
        <p class="text-center text-gray-500">Keranjang Anda masih kosong.</p>
    @else
        <div class="bg-white shadow-md rounded-lg p-6">
            @foreach($cartItems as $id => $item)
            <div class="flex items-center justify-between py-4 border-b">
                <div class="flex items-center space-x-4">
                    <img src="{{ asset('storage/' . $item['image_url']) }}" alt="{{ $item['name'] }}" class="w-16 h-16 rounded object-cover">
                    <div>
                        <p class="font-semibold">{{ $item['name'] }}</p>
                        <p class="text-sm text-gray-600">Rp{{ number_format($item['price'], 0, ',', '.') }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <span>Qty: {{ $item['quantity'] }}</span>
                    <button wire:click="removeFromCart({{ $id }})" class="text-red-500 hover:text-red-700">
                        Hapus
                    </button>
                </div>
            </div>
            @endforeach

            <div class="mt-6 text-right">
                <p class="text-2xl font-bold">Total: Rp{{ number_format($totalPrice, 0, ',', '.') }}</p>
                <a href="{{ route('checkout.index') }}" wire:navigate class="mt-4 inline-block bg-green-500 text-white font-bold py-2 px-6 rounded-lg hover:bg-green-600">
    Lanjut ke Checkout
</a>
            </div>
        </div>
    @endif
</div>