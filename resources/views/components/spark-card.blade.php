@props([
    'title' => '',
    'value' => '',
    'sparkId' => null,
    'sparkData' => null,
])
<div class="rounded-xl bg-white shadow p-4 flex flex-col items-center justify-center min-w-[180px]">
    <h2 class="text-lg font-semibold text-primary-700">{{ $title }}</h2>
    <div class="text-3xl font-bold text-primary-900 my-2">{{ $value }}</div>
    @if (!empty($sparkData) && $sparkId)
        <div class="w-full" id="{{ $sparkId }}"></div>
    @endif
</div>
