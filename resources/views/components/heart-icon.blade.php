@props([
    'active' => false,
    'size' => 'md',
])

@php
    $sizes = [
        'sm' => 'h-10 w-10',
        'md' => 'h-12 w-12',
        'lg' => 'h-16 w-16',
    ];
@endphp

<span {{ $attributes->class([
    'relative inline-flex items-center justify-center transition-transform',
    $sizes[$size] ?? $sizes['md'],
]) }}>
    <span
        aria-hidden="true"
        @class([
            'heart-shape absolute inset-0 transition-colors',
            'bg-[var(--heart)]' => $active,
            'bg-[var(--heart-soft)] group-hover:bg-[color-mix(in_oklab,var(--heart)_40%,var(--heart-soft))]' => ! $active,
        ])
    ></span>
    <span @class([
        'relative z-10 flex items-center justify-center pb-0.5',
        'text-accent-foreground' => $active,
        'text-foreground/70' => ! $active,
    ])>
        {{ $slot }}
    </span>
</span>
