<?php

namespace App\Livewire;

use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Kelola Alamat')]
class ManageUserAddresses extends Component
{
    public $addresses;

    // Properti untuk menampung data dari form tambah alamat
    public $label;
    public $recipient_name;
    public $phone;
    public $full_address;   
    public $is_primary = false;

    // Aturan validasi
    protected $rules = [
        'label' => 'required|string|max:255',
        'recipient_name' => 'required|string|max:255',
        'phone' => 'required|string|max:15',
        'full_address' => 'required|string',
    ];

    // Method ini dijalankan saat komponen dimuat
    public function mount()
    {
        $this->loadAddresses();
    }

    // Method untuk mengambil alamat dari database
    public function loadAddresses()
    {
        $this->addresses = Auth::user()->addresses()->latest()->get();
    }

    // Method untuk menyimpan alamat baru
    public function saveAddress()
    {
        $this->validate();

        // Jika user memilih "Jadikan Alamat Utama", nonaktifkan alamat utama lainnya
        if ($this->is_primary) {
            Auth::user()->addresses()->update(['is_primary' => false]);
        }

        Auth::user()->addresses()->create([
            'label' => $this->label,
            'recipient_name' => $this->recipient_name,
            'phone' => $this->phone,
            'full_address' => $this->full_address,
            'is_primary' => $this->is_primary,
        ]);

        session()->flash('success', 'Alamat baru berhasil ditambahkan.');
        $this->resetForm();
        $this->loadAddresses(); // Muat ulang daftar alamat
    }
    
    // Method untuk menghapus alamat
    public function deleteAddress($addressId)
    {
        $address = Address::where('id', $addressId)->where('user_id', Auth::id())->first();
        if ($address) {
            $address->delete();
            $this->loadAddresses(); // Muat ulang daftar alamat
            session()->flash('success', 'Alamat berhasil dihapus.');
        }
    }

    // Method untuk mereset form setelah disimpan
    public function resetForm()
    {
        $this->reset(['label', 'recipient_name', 'phone', 'full_address', 'is_primary']);
    }

    public function render()
    {
        return view('livewire.manage-user-addresses');
    }
}