<x-filament-panels::page>
    {{-- Bagian ini akan menampilkan riwayat percakapan --}}
    {{ $this->infolist }}

    {{-- Bagian ini akan menampilkan form untuk membalas pesan --}}
    <form wire:submit.prevent="sendReply" class="mt-6">
        {{ $this->form }}

        <div class="mt-4">
            <x-filament::button type="submit">
                Kirim Balasan
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>