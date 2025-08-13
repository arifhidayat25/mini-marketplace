<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">

    @if (session()->has('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p class="font-bold">Sukses</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p class="font-bold">Gagal</p>
            <p>{{ session('error') }}</p>
        </div>
    @endif


    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Detail Pesanan #{{ $order->id }}</h1>
            <p class="text-sm text-gray-500 mt-1">Dipesan pada {{ $order->created_at->format('d M Y, H:i') }}</p>
        </div>
        <a href="{{ route('akun.dashboard') }}" wire:navigate class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300">
            Kembali ke Riwayat
        </a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
        <h2 class="text-xl font-semibold mb-6">Status Pesanan</h2>
        @php
            $statuses = ['pending', 'processing', 'completed', 'cancelled'];
            $currentStatusIndex = array_search($order->status, $statuses);
            $isCancelled = $order->status == 'cancelled';
        @endphp
        <div class="flex items-center">
            @foreach($statuses as $index => $status)
                @if($status == 'cancelled') @continue @endif
                <div class="flex-1 text-center">
                    <div class="flex items-center justify-center">
                        <div @class([
                            'size-8 rounded-full flex items-center justify-center',
                            'bg-indigo-600 text-white' => !$isCancelled && $index <= $currentStatusIndex,
                            'bg-red-500 text-white' => $isCancelled,
                            'bg-gray-200 text-gray-500' => !$isCancelled && $index > $currentStatusIndex,
                        ])>
                            @if($isCancelled)
                                <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                            @elseif($index <= $currentStatusIndex)
                                <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                            @else
                                {{ $index + 1 }}
                            @endif
                        </div>
                        @if(!$loop->last && $statuses[$index+1] != 'cancelled')
                            <div @class([
                                'flex-1 h-1',
                                'bg-indigo-600' => !$isCancelled && $index < $currentStatusIndex,
                                'bg-red-500' => $isCancelled,
                                'bg-gray-200' => !$isCancelled && $index >= $currentStatusIndex,
                            ])></div>
                        @endif
                    </div>
                    <p @class([
                        'mt-2 text-xs md:text-sm',
                        'font-semibold text-indigo-600' => !$isCancelled && $index <= $currentStatusIndex,
                        'text-red-600 font-semibold' => $isCancelled && $index == $currentStatusIndex,
                        'text-gray-500' => $isCancelled ? $index != $currentStatusIndex : $index > $currentStatusIndex,
                    ])>{{ ucfirst($status) }}</p>
                </div>
            @endforeach
        </div>
        @if($isCancelled)
            <p class="text-center text-red-600 mt-4">Pesanan ini telah dibatalkan.</p>
        @endif
    </div>


    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4">Item yang Dipesan</h2>
                @foreach($order->orderItems as $item)
                <div class="flex flex-col sm:flex-row items-center justify-between py-4 {{ !$loop->last ? 'border-b' : '' }}">
                    <div class="flex items-center space-x-4 mb-4 sm:mb-0">
                        <img src="{{ asset('storage/' . $item->product->image_url) }}" alt="{{ $item->product->name }}" class="w-20 h-20 rounded object-cover">
                        <div>
                            <p class="font-semibold text-gray-800">{{ $item->product->name }}</p>
                            <p class="text-sm text-gray-600">{{ $item->quantity }} x Rp{{ number_format($item->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <p class="font-bold text-lg">Rp{{ number_format($item->quantity * $item->price, 0, ',', '.') }}</p>
                        <button wire:click="buyAgain({{ $item->product->id }})" class="px-4 py-2 bg-indigo-100 text-indigo-700 text-xs font-semibold rounded-lg hover:bg-indigo-200">
                            Beli Lagi
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

             <div class="bg-white p-6 rounded-lg shadow-md">
                 <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-semibold text-gray-800">Butuh Bantuan?</h3>
                        <p class="text-sm text-gray-600">Hubungi customer service kami jika ada kendala.</p>
                    </div>
                    <a href="#" class="px-4 py-2 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600">Hubungi Kami</a>
                 </div>
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
                <h2 class="text-xl font-semibold mb-4">Informasi Pengiriman</h2>
                <div class="mb-4">
                    <h3 class="font-semibold text-gray-700">Alamat</h3>
                    <address class="not-italic text-gray-600">
                        <strong>{{ $order->name }}</strong><br>
                        {{ $order->address }}<br>
                        {{ $order->phone }}
                    </address>
                </div>
                 @if($order->status == 'completed') {{-- Asumsi: status 'dikirim' adalah 'completed' --}}
                    <div>
                        <h3 class="font-semibold text-gray-700">Kurir & Resi</h3>
                        <p class="text-gray-600">JNE Express</p> {{-- Ganti dengan data asli --}}
                        <div class="flex justify-between items-center mt-1">
                            <p class="text-gray-600 font-mono bg-gray-100 px-2 py-1 rounded">CGK1234567890</p> {{-- Ganti dengan data asli --}}
                            <button class="text-sm text-indigo-600 hover:underline">Salin</button>
                        </div>
                        <button class="mt-4 w-full px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700">Lacak Pengiriman</button>
                    </div>
                 @endif
            </div>
        </div>
    </div>
</div>