<div x-data="{ open: false }" class="relative">
    @if($conversations && $conversations->isNotEmpty())
    <button @click="open = !open" class="relative">
        <svg xmlns="http://www.w.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
        @if ($unreadCount > 0)
            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                {{ $unreadCount }}
            </span>
        @endif
    </button>

    <div x-show="open" 
         @click.away="open = false" 
         x-transition
         class="absolute z-50 mt-2 w-80 rounded-md shadow-lg origin-top-right right-0"
         style="display: none;">
        <div class="rounded-md ring-1 ring-black ring-opacity-5 bg-white">
            <div class="p-4 border-b">
                <p class="font-semibold">Kotak Masuk</p>
            </div>
            <div class="py-1 max-h-96 overflow-y-auto">
                @forelse($conversations as $conversation)
                    <button wire:click="openChat({{ $conversation->product_id }})" class="w-full text-left block px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">
                        <p class="font-bold truncate">Re: {{ $conversation->product->name }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $conversation->updated_at->diffForHumans() }}</p>
                    </button>
                @empty
                    <p class="text-center text-gray-500 py-4">Tidak ada percakapan.</p>
                @endforelse
            </div>
        </div>
    </div>
    @endif
</div>