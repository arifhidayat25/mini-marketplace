<div x-data="{ open: false }" class="relative">
    <button @click="open = !open" class="relative">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        @if ($unreadCount > 0)
            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                {{ $unreadCount }}
            </span>
        @endif
    </button>

    <div x-show="open" 
         @click.away="open = false" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute z-50 mt-2 w-80 rounded-md shadow-lg origin-top-right right-0"
         style="display: none;">
        <div class="rounded-md ring-1 ring-black ring-opacity-5 bg-white">
            <div class="p-4 border-b">
                <p class="font-semibold">Notifikasi</p>
            </div>
            <div class="py-1">
                @forelse($notifications as $notification)
                    <a href="{{ $notification->data['link'] ?? '#' }}" 
                       wire:click.prevent="markAsRead('{{ $notification->id }}')" 
                       class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 {{ is_null($notification->read_at) ? 'bg-blue-50' : '' }}">
                        <p class="font-bold">{{ $notification->data['title'] }}</p>
                        <p>{{ $notification->data['message'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                    </a>
                @empty
                    <p class="text-center text-gray-500 py-4">Tidak ada notifikasi.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>