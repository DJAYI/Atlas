<x-app-layout>
    <x-utils.language-selector route="assistance" />

    <div
        class="grid w-auto min-h-screen grid-cols-1 grid-rows-[100px_1fr] gap-5 mx-auto bg-white sm:max-w-5xl rounded-t-xl md:grid-cols-1 ">

        <nav class="flex flex-row items-center gap-4 p-6">
            <li class="list-none w-fit">
                <a class="flex flex-row items-center gap-1 px-4 py-2 text-lg font-semibold transition rounded-md shadow-xl group shadow-transparent hover:shadow-red-300 ring-1 hover:ring-4 ring-red-300 hover:text-white w-fit hover:bg-red-500"
                    href="{{ route('home', ['locale' => 'es']) }}">
                    <span class="transition group-hover:scale-110 group-hover:-translate-x-2">
                        @php
                            $menuIcon = public_path('icons/back-arrow.svg');
                            echo file_get_contents($menuIcon);
                        @endphp
                    </span>
                    <span class="transition group-hover:-translate-x-1">{{ __('Volver') }}</span>
                </a>
            </li>

            <li class="w-2/5 mx-3 list-none">
                <span>
                    <h1 class="text-3xl font-black drop-shadow-md ">
                        {{ __('Registra tu Asistencia') }}
                    </h1>
                </span>
            </li>
        </nav>

    </div>
</x-app-layout>
