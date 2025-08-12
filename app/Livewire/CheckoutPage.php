<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\Product;
use App\Models\Address; // Pastikan ini di-import



#[Layout('layouts.app')]
#[Title('Checkout')]
class CheckoutPage extends Component
{
    public $name;
    public $email;
    public $phone;
    public $address;
     public $savedAddresses; // Untuk menampung daftar alamat
    public $selectedAddressId;

    public $cartItems = [];
    public $totalPrice = 0;

    // Aturan validasi untuk form
    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:15',
        'address' => 'required|string|max:500',
    ];

    public function mount()
{
    // Ambil data keranjang dari session
    $this->cartItems = session()->get('cart', []);
    
    // Redirect jika keranjang kosong
    if (empty($this->cartItems)) {
        return redirect()->route('home');
    }

    // Hitung total harga
    foreach ($this->cartItems as $item) {
        $this->totalPrice += $item['price'] * $item['quantity'];
    }

    // Lakukan semua pengecekan untuk pengguna yang login dalam satu blok
    if (auth()->check()) {
        $user = auth()->user();
        
        // Isi form otomatis dengan data akun
        $this->name = $user->name;
        $this->email = $user->email;

        // Ambil alamat yang sudah tersimpan milik pengguna
        $this->savedAddresses = $user->addresses;
        
        // Pilih alamat utama sebagai default jika ada
        if ($this->savedAddresses && $this->savedAddresses->count() > 0) {
            $primaryAddress = $this->savedAddresses->firstWhere('is_primary', true);
            if ($primaryAddress) {
                $this->selectAddress($primaryAddress->id);
            }
        }
    }
}

    

    public function placeOrder()
{
    $this->validate();

    // ---- VALIDASI STOK (BAGIAN BARU 1) ----
    foreach ($this->cartItems as $productId => $item) {
        $product = Product::find($productId);
        if ($product->stock < $item['quantity']) {
            // Jika stok tidak cukup, kirim pesan error dan hentikan proses
            session()->flash('error', 'Stok produk ' . $product->name . ' tidak mencukupi. Sisa stok: ' . $product->stock);
            return;
        }
    }
    // ---- AKHIR VALIDASI STOK ----

    DB::transaction(function () {
        // 1. Buat record di tabel 'orders'
        $order = Order::create([
            'user_id' => auth()->id(),
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'total_price' => $this->totalPrice,
            'status' => 'pending',
        ]);

        // 2. Buat record di tabel 'order_items' & kurangi stok
        foreach ($this->cartItems as $productId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);

            // ---- KURANGI STOK (BAGIAN BARU 2) ----
            $product = Product::find($productId);
            $product->decrement('stock', $item['quantity']);
            // ---- AKHIR PENGURANGAN STOK ----
        }

        // 3. Kosongkan keranjang
        session()->forget('cart');

        // 4. Kirim event untuk update counter keranjang
        $this->dispatch('cart-updated');

        // 5. Redirect ke halaman sukses
        return redirect()->route('order.success');
    });
}

    public function render()
    {
        return view('livewire.checkout-page');
    }
    // Method baru untuk memilih alamat
    public function selectAddress($addressId)
    {
        $address = Address::find($addressId);
        if ($address && $address->user_id === auth()->id()) {
            $this->name = $address->recipient_name;
            $this->phone = $address->phone;
            $this->address = $address->full_address;
            $this->selectedAddressId = $address->id;
        }
    }
}