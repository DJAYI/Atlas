@props(['route'])
<nav style="view-transition-name: language-selector">
    {{-- Lista de idiomas [ES, EN] --}}
    <ul class="flex items-center justify-center gap-4 p-4 text-lg font-semibold text-gray-700">
        @foreach (config('app.available_locales') as $locale)
            <li>
                <a href="{{ route($route, ['locale' => $locale]) }}"
                    class="px-4 py-2 transition duration-300 ease-in-out rounded-md hover:bg-primary-500 hover:text-white {{ app()->getLocale() === $locale ? 'bg-primary-500 text-white' : '' }}">
                    {{ strtoupper($locale) }}
                </a>
            </li>
        @endforeach
    </ul>
</nav>
