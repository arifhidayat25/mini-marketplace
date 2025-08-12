<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Detail Pesanan #{{ $order->id }}</h1>
    <p class="text-sm text-gray-500 mb-6">Dipesan pada {{ $order->created_at->format('d M Y, H:i') }}</p>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4">Item yang Dipesan</h2>
                @foreach($order->orderItems as $item)
                <div class="flex items-center justify-between py-4 {{ !$loop->last ? 'border-b' : '' }}">
                    <div class="flex items-center space-x-4">
                        <img src="{{ asset('storage/' . $item->product->image_url) }}" alt="{{ $item->product->name }}" class="w-20 h-20 rounded object-cover">
                        <div>
                            <p class="font-semibold text-gray-800">{{ $item->product->name }}</p>
                            <p class="text-sm text-gray-600">{{ $item->quantity }} x Rp{{ number_format($item->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <p class="font-bold">Rp{{ number_format($item->quantity * $item->price, 0, ',', '.') }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <div class="lg:col-span-1 space-y-8">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4">Ringkasan Total</h2>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span>Rp{{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Biaya Pengiriman</span>
                        <span>Gratis</span>
                    </div>
                    <div class="flex justify-between font-bold text-lg border-t pt-2 mt-2">
                        <span>Total</span>
                        <span>Rp{{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4">Alamat Pengiriman</h2>
                <address class="not-italic text-gray-600">
                    <strong>{{ $order->name }}</strong><br>
                    {{ $order->address }}<br>
                    {{ $order->phone }}<br>
                    {{ $order->email }}
                </address>
            </div>
        </div>
    </div>
</div>