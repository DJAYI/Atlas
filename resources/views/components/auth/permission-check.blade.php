@props(['permission' => ''])

@if (auth()->check() && auth()->user()->can($permission))
    {{ $slot }}
@endif
