@props(['route'])
<nav style="view-transition-name: language-selector">
    {{-- Lista de idiomas [ES, EN] --}}
    <ul class="flex items-center justify-center gap-4 p-4 text-lg font-semibold text-gray-700">
        @foreach (config('app.available_locales') as $locale)
            <li>
                <a href="{{ route($route, ['locale' => $locale]) }}"
                    class="px-4 py-2 flex items-center gap-3 transition duration-300 ease-in-out rounded-md hover:bg-primary-400 hover:text-white {{ app()->getLocale() === $locale ? 'bg-primary-400 text-white' : '' }}">
                    {{-- Icono de bandera --}}
                    @if ($locale === 'es')
                        <img src="{{ asset('icons/es-flag.svg') }}" alt="">
                    @elseif ($locale === 'en')
                        <img src="{{ asset('icons/en-flag.svg') }}" alt="">
                    @endif

                    {{ strtoupper($locale) }}
                </a>
            </li>
        @endforeach
    </ul>
</nav>
