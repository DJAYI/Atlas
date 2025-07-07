@props(['role' => ''])

@if (auth()->check() && auth()->user()->hasRole($role))
    {{ $slot }}
@endif
