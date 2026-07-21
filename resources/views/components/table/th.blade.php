@props([
    'header',
    'name'
])

<div
    wire:click="sortBy('{{ $name }}', '{{ $header['sortDirection'] === 'asc' ? 'desc' : 'asc' }}')"
    class="cursor-pointer"
>
    {{ $header['label'] }} @if($header['sortColumnBy'] === $name)
        <x-icon :name="$header['sortDirection'] === 'asc' ? 'o-chevron-down' : 'o-chevron-up'" class="h-4 w-4" />
    @endif
</div>
