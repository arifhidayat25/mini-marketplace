<x-app-layout>
    <div class="container mx-auto px-4 py-12 text-center">
        <h1 class="text-4xl font-bold text-green-500 mb-4">Terima Kasih!</h1>
        <p class="text-lg text-gray-700 mb-6">Pesanan Anda telah berhasil dibuat dan akan segera kami proses.</p>
        <a href="{{ route('home') }}" class="bg-indigo-600 text-white font-bold py-2 px-6 rounded-lg hover:bg-indigo-700">
            Kembali ke Halaman Utama
        </a>
    </div>
</x-app-layout>