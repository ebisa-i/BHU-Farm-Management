@php
    /** @var \App\Models\User $avatarUser */
    $avatarUser = $avatarUser ?? auth()->user();
    $size       = $size      ?? 'h-9 w-9';
    $textSize   = $textSize  ?? 'text-sm';

    // Cache-bust using the updated_at timestamp so browsers always fetch
    // the latest photo when the user changes it, even if the filename were similar.
    $photoUrl = $avatarUser?->profilePhotoUrl()
        ? $avatarUser->profilePhotoUrl() . '?v=' . ($avatarUser->updated_at?->timestamp ?? time())
        : null;
@endphp

@if ($photoUrl)
    <img
        src="{{ $photoUrl }}"
        alt="{{ $avatarUser->name }}"
        class="{{ $size }} rounded-full object-cover ring-2 ring-[#c4dac8]"
    >
@else
    <span class="{{ $size }} inline-flex items-center justify-center rounded-full bg-[#e2eddd] font-bold {{ $textSize }} text-[#32634d]">
        {{ strtoupper(substr($avatarUser?->name ?? 'U', 0, 1)) }}
    </span>
@endif
