<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800">
        Dashboard, <span class="text-indigo-600">{{ auth()->user()->name }}</span>!
    </h1>
    <a href="{{ route('akun.alamat') }}" class="bg-indigo-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-indigo-600 hidden md:inline-block">
        Kelola Alamat
    </a>
</div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center space-x-4">
            <div class="bg-blue-100 p-3 rounded-full">
                <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Total Pesanan</p>
                <p class="text-2xl font-bold">{{ $orderCount }}</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center space-x-4">
            <div class="bg-green-100 p-3 rounded-full">
                <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v.01"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Total Belanja</p>
                <p class="text-2xl font-bold">Rp{{ number_format($totalSpent, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <div>
    <h2 class="text-xl font-semibold mb-4 text-gray-800">Riwayat Pesanan Terbaru</h2>
    <div class="space-y-4">
        @forelse($orders as $order)
            <div class="bg-white p-4 rounded-lg shadow-md transition hover:shadow-lg">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                    <div class="flex-1 mb-4 sm:mb-0">
                        <div class="flex items-center gap-4">
                            <p class="font-bold text-indigo-600">No. Pesanan: #{{ $order->id }}</p>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($order->status == 'pending') bg-yellow-100 text-yellow-800 @endif
                                @if($order->status == 'processing') bg-blue-100 text-blue-800 @endif
                                @if($order->status == 'completed') bg-green-100 text-green-800 @endif
                                @if($order->status == 'cancelled') bg-red-100 text-red-800 @endif
                            ">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500 mt-1">
                            Tanggal: {{ $order->created_at->format('d M Y') }}
                        </p>
                    </div>
                    <div class="flex items-center gap-6 w-full sm:w-auto">
                        <div class="text-left sm:text-right">
                            <p class="text-sm text-gray-500">Total</p>
                            <p class="font-bold text-gray-800">Rp{{ number_format($order->total_price, 0, ',', '.') }}</p>
                        </div>
                        <a href="{{ route('akun.order.detail', $order) }}" wire:navigate class="bg-gray-200 text-gray-800 font-bold py-2 px-4 rounded-lg hover:bg-gray-300 text-sm whitespace-nowrap">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white p-6 rounded-lg shadow-md text-center text-gray-500">
                Anda belum memiliki riwayat pesanan.
            </div>
        @endforelse
    </div>
</div>
</div>