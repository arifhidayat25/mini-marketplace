<x-filament-panels::page>
    <div class="flex flex-col h-[70vh] bg-white dark:bg-gray-800 rounded-lg shadow">
        
        {{-- Header Chat --}}
        <div class="p-4 border-b dark:border-gray-700">
            <h2 class="font-semibold text-lg">Pelanggan: {{ $record->user->name }}</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Produk: 
                <a href="{{ route('product.detail', $record->product) }}" target="_blank" class="text-primary-500 hover:underline">
                    {{ $record->product->name }}
                </a>
            </p>
        </div>

        {{-- Badan Chat (Riwayat Pesan) --}}
        <div class="flex-1 p-4 space-y-4 overflow-y-auto">
            @foreach ($record->messages as $message)
                @php
                    $isSender = $message->user_id === null; // True jika pengirimnya admin
                @endphp
                <div @class(['flex', 'justify-end' => $isSender, 'justify-start' => !$isSender])>
                    <div @class([
                        'max-w-md rounded-lg px-3 py-2 text-sm',
                        'bg-primary-500 text-white' => $isSender,
                        'bg-gray-200 dark:bg-gray-700' => !$isSender,
                    ])>
                        <p class="font-semibold">
                            {{ $isSender ? 'Anda' : $message->sender?->name ?? 'Pengguna Dihapus' }}
                        </p>
                        <p class="whitespace-pre-wrap">{{ $message->body }}</p>
                        <p class="mt-1 text-xs text-right opacity-70">
                            {{ $message->created_at->format('H:i') }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Footer Chat (Form Balasan) --}}
        <div class="p-4 border-t dark:border-gray-700">
            <form wire:submit.prevent="sendMessage">
                {{ $this->form }}
                <div class="mt-2">
                    <x-filament::button type="submit">
                        Kirim
                    </x-filament::button>
                </div>
            </form>
        </div>
    </div>
</x-filament-panels::page>