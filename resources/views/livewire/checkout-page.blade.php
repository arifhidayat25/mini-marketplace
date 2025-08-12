<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Checkout</h1>

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Gagal!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

        <div class="md:col-span-2">
            <div class="bg-white p-6 rounded-lg shadow-md">

                @if(Auth::check() && $savedAddresses && $savedAddresses->count() > 0)
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-3">Pilih Alamat Tersimpan</h3>
                    <div class="space-y-3">
                        @foreach($savedAddresses as $address)
                        <label wire:click="selectAddress({{ $address->id }})" class="flex items-start p-4 border rounded-lg cursor-pointer {{ $selectedAddressId == $address->id ? 'border-indigo-500 bg-indigo-50' : 'border-gray-300' }}">
                            <input type="radio" name="selected_address" value="{{ $address->id }}" {{ $selectedAddressId == $address->id ? 'checked' : '' }} class="h-5 w-5 mt-1 text-indigo-600 focus:ring-indigo-500">
                            <div class="ml-4">
                                <p class="font-semibold">{{ $address->label }} ({{ $address->recipient_name }}) @if($address->is_primary)<span class="text-xs text-green-600 font-bold">[Utama]</span>@endif</p>
                                <p class="text-sm text-gray-600">{{ $address->full_address }}</p>
                                <p class="text-sm text-gray-600">{{ $address->phone }}</p>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
                <hr class="my-6">
                <h2 class="text-xl font-semibold mb-4">Atau Isi Alamat Pengiriman Baru</h2>
                @else
                <h2 class="text-xl font-semibold mb-4">Alamat Pengiriman</h2>
                @endif
                <form wire:submit.prevent="placeOrder">
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700">Nama Lengkap Penerima</label>
                        <input type="text" id="name" wire:model.defer="name" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700">Email</label>
                        <input type="email" id="email" wire:model.defer="email" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label for="phone" class="block text-gray-700">Nomor Telepon</label>
                        <input type="text" id="phone" wire:model.defer="phone" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                        @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label for="address" class="block text-gray-700">Alamat Lengkap</label>
                        <textarea id="address" wire:model.defer="address" rows="4" class="w-full mt-1 border-gray-300 rounded-md shadow-sm"></textarea>
                        @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-indigo-700">
                        Buat Pesanan
                    </button>
                </form>
            </div>
        </div>

        <div class="md:col-span-1">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4">Ringkasan Pesanan</h2>
                @foreach($cartItems as $item)
                <div class="flex justify-between items-center mb-2">
                    <span>{{ $item['name'] }} <span class="text-gray-500">x{{ $item['quantity'] }}</span></span>
                    <span>Rp{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                </div>
                @endforeach
                <div class="border-t mt-4 pt-4">
                    <div class="flex justify-between font-bold text-lg">
                        <span>Total</span>
                        <span>Rp{{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>