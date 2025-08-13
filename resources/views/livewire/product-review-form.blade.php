@if($showReviewModal)
<div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-lg font-semibold mb-4">Beri Ulasan</h2>
        <textarea wire:model="reviewText" rows="4" class="w-full border rounded p-2"></textarea>
        <div class="flex justify-end mt-4 space-x-2">
            <button wire:click="$set('showReviewModal', false)" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Batal</button>
            <button wire:click="saveReview" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Kirim</button>
        </div>
    </div>
</div>
@endif
