@props([
    'variant' => 'default',
    'showName' => true,
    'area' => null,
    'size' => 'md',
])

@php
    $logoUrl = config('portal.logo_url') ?: asset('images/logo.png');

    $imgSize = match ($size) {
        'sm' => 'h-7',
        'lg' => 'h-12',
        default => 'h-9',
    };

    $isLight = $variant === 'light';
@endphp

<div {{ $attributes->merge(['class' => 'flex items-center gap-3 min-w-0']) }}>
    @if ($logoUrl)
        <img src="{{ $logoUrl }}"
             alt="SkyLink MBC"
             class="{{ $imgSize }} w-auto object-contain flex-shrink-0 {{ $isLight ? 'brightness-0 invert' : '' }}">
    @else
        <div class="flex-shrink-0 rounded-lg bg-gradient-to-br from-skylink-500 to-skylink-800 flex items-center justify-center text-white font-bold {{ $size === 'lg' ? 'w-12 h-12 text-base' : 'w-9 h-9 text-sm' }}">
            SL
        </div>
    @endif

    @if ($showName)
        <div class="min-w-0">
            <p @class([
                'font-semibold truncate',
                'text-white' => $isLight,
                'text-skylink-900' => ! $isLight,
            ])>SkyLink MBC</p>
            @if ($area)
                <p @class([
                    'text-xs truncate',
                    'text-skylink-300' => $isLight,
                    'text-slate-500' => ! $isLight,
                ])>{{ $area }}</p>
            @endif
        </div>
    @endif
</div>
