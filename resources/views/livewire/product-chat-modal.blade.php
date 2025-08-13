<div>
    @if($isOpen)
    <div class="fixed inset-0 bg-gray-900 bg-opacity-50 z-40" x-data @click="$wire.closeModal()"></div>
    <div 
        class="fixed bottom-0 right-0 sm:bottom-4 sm:right-4 w-full sm:w-96 bg-white rounded-t-lg sm:rounded-lg shadow-2xl border border-gray-200 flex flex-col z-50"
        style="height: 70vh; max-height: 500px;">

        <div class="p-4 border-b bg-gray-50 rounded-t-lg flex justify-between items-center">
            <div>
                <h3 class="font-semibold text-lg text-gray-800">Tanya tentang produk</h3>
                <p class="text-sm text-gray-500 truncate">{{ $product->name ?? '' }}</p>
            </div>
            <button @click="$wire.closeModal()" class="text-gray-400 hover:text-gray-600">&times;</button>
        </div>

        <div class="flex-1 p-4 overflow-y-auto">
            @if($messages)
                @forelse($messages as $message)
                     <div @class(['flex mb-3', 'justify-end' => $message->user_id === Auth::id(), 'justify-start' => $message->user_id === null])>
                        <div @class(['rounded-lg px-4 py-2 max-w-xs', 'bg-indigo-500 text-white' => $message->user_id === Auth::id(), 'bg-gray-200 text-gray-800' => $message->user_id === null])>
                            <p class="text-sm">{{ $message->body }}</p>
                            <p class="text-xs mt-1 text-right {{ $message->user_id === Auth::id() ? 'text-indigo-200' : 'text-gray-500' }}">{{ $message->created_at->format('H:i') }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500 text-sm">Belum ada pesan. Mulai percakapan Anda!</p>
                @endforelse
            @endif
        </div>

        <div class="p-4 border-t bg-white rounded-b-lg">
            <form wire:submit.prevent="sendMessage">
                <div class="flex items-center space-x-2">
                    <input wire:model="body" type="text" placeholder="Ketik pesan Anda..." autocomplete="off" class="w-full border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500">
                    <button type="submit" class="bg-indigo-600 text-white rounded-lg p-3 hover:bg-indigo-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" /></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>