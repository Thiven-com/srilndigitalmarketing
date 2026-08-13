@props([
    'route' => '#',
    'icon'  => null,
    'label' => null,
])

@php
    $isActive = request()->routeIs($route);
@endphp

<a href="{{ route($route) }}"
   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm
          {{ $isActive ? 'bg-blue-600 text-white' : 'text-slate-700 hover:bg-slate-100' }}">

    @if($icon)
        <i class="fa-solid {{ $icon }} text-[15px]"></i>
    @endif

    <span>{{ $label }}</span>
</a>
