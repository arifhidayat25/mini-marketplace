<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Kelola Alamat Saya</h1>

    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div x-data="{ open: false }" class="bg-white p-6 rounded-lg shadow-md mb-8">
        <button @click="open = !open" class="w-full bg-indigo-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-indigo-600">
            <span x-show="!open">Tambah Alamat Baru</span>
            <span x-show="open">Tutup Form</span>
        </button>

        <div x-show="open" x-transition class="mt-6">
            <form wire:submit.prevent="saveAddress">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="label" class="block text-gray-700">Label Alamat (Contoh: Rumah, Kantor)</label>
                        <input type="text" id="label" wire:model="label" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                        @error('label') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="recipient_name" class="block text-gray-700">Nama Penerima</label>
                        <input type="text" id="recipient_name" wire:model="recipient_name" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                        @error('recipient_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="phone" class="block text-gray-700">Nomor Telepon</label>
                        <input type="text" id="phone" wire:model="phone" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                        @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="full_address" class="block text-gray-700">Alamat Lengkap</label>
                        <textarea id="full_address" wire:model="full_address" rows="3" class="w-full mt-1 border-gray-300 rounded-md shadow-sm"></textarea>
                        @error('full_address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="mt-4 flex items-center">
                    <input type="checkbox" id="is_primary" wire:model="is_primary" class="h-4 w-4 text-indigo-600 rounded">
                    <label for="is_primary" class="ml-2 block text-sm text-gray-900">Jadikan Alamat Utama</label>
                </div>
                <div class="mt-6">
                    <button type="submit" class="bg-green-500 text-white font-bold py-2 px-6 rounded-lg hover:bg-green-600">
                        Simpan Alamat
                    </button>
                    <button type="button" @click="open = false" wire:click="resetForm" class="ml-2 text-gray-600">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <h2 class="text-2xl font-bold text-gray-800 mb-4">Alamat Tersimpan</h2>
    <div class="space-y-4">
        @forelse($addresses as $address)
            <div class="bg-white p-4 rounded-lg shadow-md flex justify-between items-start">
                <div>
                    <p class="font-bold text-lg">{{ $address->label }} 
                        @if($address->is_primary) 
                            <span class="text-xs ml-2 px-2 py-1 bg-green-200 text-green-800 rounded-full">Utama</span>
                        @endif
                    </p>
                    <p class="text-gray-700">{{ $address->recipient_name }}</p>
                    <p class="text-gray-600">{{ $address->full_address }}</p>
                    <p class="text-gray-600">{{ $address->phone }}</p>
                </div>
                <div>
                    <button wire:click="deleteAddress({{ $address->id }})" wire:confirm="Anda yakin ingin menghapus alamat ini?" class="text-red-500 hover:text-red-700">
                        Hapus
                    </button>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500">Anda belum memiliki alamat tersimpan.</p>
        @endforelse
    </div>
</div>