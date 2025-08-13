@php
    $message = $getRecord();
    $isSender = $message->user_id === null; // True jika pengirimnya adalah admin
@endphp

<div @class([
    'flex w-full',
    'justify-end' => $isSender,
    'justify-start' => !$isSender,
])>
    <div class="max-w-xs rounded-lg px-3 py-2 text-sm" style="background-color: {{ $isSender ? 'var(--primary-500)' : 'var(--gray-200)' }}; color: {{ $isSender ? 'var(--white)' : 'var(--gray-800)' }};">
        <p class="font-semibold">
            {{-- GANTI BARIS INI --}}
            {{ $isSender ? 'Anda (Admin)' : ($message->sender?->name ?? 'Pengguna Dihapus') }}
        </p>
        <p class="whitespace-pre-wrap">{{ $message->body }}</p>
        <p class="mt-1 text-xs text-right opacity-70">
            {{ $message->created_at->format('H:i') }}
        </p>
    </div>
</div>