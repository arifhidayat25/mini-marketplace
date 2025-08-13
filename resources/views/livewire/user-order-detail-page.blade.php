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

                        {{-- Logika Tombol Ulasan --}}
                        @if($order->status == 'completed')
                            @if($item->review)
                                <span class="text-sm text-green-600 px-4 py-2">Sudah diulas</span>
                            @else
                                <button wire:click="openReviewModal({{ $item->id }})" class="text-sm text-indigo-600 hover:underline px-4 py-2">
                                    Beri Ulasan
                                </button>
                            @endif
                        @endif

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
                 @if($order->status == 'completed')
                    <div>
                        <h3 class="font-semibold text-gray-700">Kurir & Resi</h3>
                        <p class="text-gray-600">JNE Express</p>
                        <div class="flex justify-between items-center mt-1">
                            <p class="text-gray-600 font-mono bg-gray-100 px-2 py-1 rounded">CGK1234567890</p>
                            <button class="text-sm text-indigo-600 hover:underline">Salin</button>
                        </div>
                        <button class="mt-4 w-full px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700">Lacak Pengiriman</button>
                    </div>
                 @endif
            </div>
        </div>
    </div>

    {{-- Modal untuk Memberi Ulasan --}}
    @if($showReviewModal)
    <div class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50 transition-opacity" x-data="{ show: @entangle('showReviewModal') }" x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="bg-white rounded-lg p-8 m-4 max-w-md w-full transform transition-all" @click.away="show = false" x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            <h2 class="text-2xl font-bold mb-4">Beri Ulasan untuk</h2>
            @if($selectedOrderItem)
            <p class="font-semibold text-gray-700 mb-6">{{ $selectedOrderItem->product->name }}</p>
            
            <form wire:submit.prevent="submitReview">
                {{-- Rating Bintang --}}
                <div class="mb-4">
                    <label class="block font-semibold mb-2">Rating Anda</label>
                    <div class="flex items-center space-x-1">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg wire:click="$set('rating', {{ $i }})" class="w-8 h-8 cursor-pointer {{ $rating >= $i ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        @endfor
                    </div>
                    @error('rating') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                
                {{-- Komentar --}}
                <div class="mb-6">
                    <label for="comment" class="block font-semibold mb-2">Komentar (Opsional)</label>
                    <textarea wire:model="comment" id="comment" rows="4" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                    @error('comment') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex justify-end space-x-4">
                    <button type="button" wire:click="$set('showReviewModal', false)" class="px-4 py-2 bg-gray-200 rounded-lg font-semibold hover:bg-gray-300">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700">Kirim Ulasan</button>
                </div>
            </form>
            @endif
        </div>
    </div>
    @endif

</div>
