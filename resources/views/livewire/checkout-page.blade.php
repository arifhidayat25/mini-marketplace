<div class="bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-bold mb-8 text-gray-800">Checkout</h1>

        @if (session()->has('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p class="font-bold">Gagal!</p>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <form wire:submit.prevent="placeOrder">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h2 class="text-xl font-semibold mb-4">1. Alamat Pengiriman</h2>
                        @if(Auth::check() && $savedAddresses && $savedAddresses->count() > 0)
                        <div class="space-y-3">
                            @foreach($savedAddresses as $address)
                            <label wire:click="selectAddress({{ $address->id }})" class="flex items-start p-4 border rounded-lg cursor-pointer {{ $selectedAddressId == $address->id ? 'border-indigo-500 bg-indigo-50' : 'border-gray-300' }}">
                                <input type="radio" name="selected_address" value="{{ $address->id }}" {{ $selectedAddressId == $address->id ? 'checked' : '' }} class="h-5 w-5 mt-1 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                <div class="ml-4">
                                    <p class="font-semibold">{{ $address->label }} ({{ $address->recipient_name }}) @if($address->is_primary)<span class="text-xs text-green-600 font-bold">[Utama]</span>@endif</p>
                                    <p class="text-sm text-gray-600">{{ $address->full_address }}</p>
                                    <p class="text-sm text-gray-600">{{ $address->phone }}</p>
                                </div>
                            </label>
                            @endforeach
                        </div>
                        <hr class="my-6">
                        <h3 class="text-lg font-semibold mb-4">Atau Isi Alamat Baru</h3>
                        @endif
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                             <div class="sm:col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap Penerima</label>
                                <input type="text" id="name" wire:model.defer="name" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" id="email" wire:model.defer="email" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                                <input type="text" id="phone" wire:model.defer="phone" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                                @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div class="sm:col-span-2">
                                <label for="address" class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                                <textarea id="address" wire:model.defer="address" rows="3" class="w-full mt-1 border-gray-300 rounded-md shadow-sm"></textarea>
                                @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h2 class="text-xl font-semibold mb-4">2. Pilihan Kurir</h2>
                        <div class="space-y-3">
                            <label class="flex items-start p-4 border rounded-lg cursor-pointer border-indigo-500 bg-indigo-50">
                                <input type="radio" name="courier" checked class="h-5 w-5 mt-1 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                <div class="ml-4 flex justify-between w-full">
                                    <div>
                                        <p class="font-semibold">Reguler</p>
                                        <p class="text-sm text-gray-600">Estimasi tiba 2-3 hari</p>
                                    </div>
                                    <p class="font-semibold text-sm">Gratis</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h2 class="text-xl font-semibold mb-4">3. Metode Pembayaran</h2>
                        <div class="space-y-3">
                            <label class="flex items-center p-4 border rounded-lg cursor-pointer">
                                <input type="radio" name="payment_method" class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                <span class="ml-4 font-semibold">Transfer Bank</span>
                            </label>
                             <label class="flex items-center p-4 border rounded-lg cursor-pointer">
                                <input type="radio" name="payment_method" class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                <span class="ml-4 font-semibold">GoPay / E-Wallet</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-white p-6 rounded-lg shadow-md sticky top-24">
                        <h2 class="text-xl font-semibold mb-4">Ringkasan Pesanan</h2>
                        @foreach($cartItems as $item)
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-gray-600">{{ $item['name'] }} <span class="text-gray-500">x{{ $item['quantity'] }}</span></span>
                            <span class="font-medium">Rp{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                        <div class="border-t mt-4 pt-4">
                            <div class="flex justify-between font-bold text-lg">
                                <span>Total</span>
                                <span>Rp{{ number_format($totalPrice, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="mt-6 text-center text-sm text-gray-500 flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            Transaksi aman dan terenkripsi.
                        </div>

                        <button type="submit" class="mt-4 w-full bg-indigo-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-indigo-700 transition-colors">
                            Bayar Sekarang
                        </button>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>