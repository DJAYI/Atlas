@props(['title' => 'Sistema de Internacionalización de Eventos'])

<x-app-layout>
    <header style="view-transition-name: dashboard-header"
        class="flex flex-col items-center justify-between w-full gap-5 px-4 py-3 bg-white/90 sm:flex-row">
        <div class="flex items-center justify-between gap-6">
            <h1 class="text-3xl font-black text-green-700">Hermes</h1>
            <button
                class="p-2 transition sm:hidden outline outline-green-300 hover:outline-4 hover:outline-green-400 hover:shadow-md hover:shadow-green-200 rounded-xl hover:ring-8 hover:ring-green-200 "
                id="menu-btn">
                @php
                    $menuIcon = public_path('icons/bars-menu.svg');
                    echo file_get_contents($menuIcon);
                @endphp
            </button>
        </div>

        <nav id="menu" class="flex flex-col md:flex-row [&>*]:list-none items-center gap-5 rounded-xl p-4">
            <li class="transition hover:scale-95"><a
                    class="text-black hover:shadow-[1px_1px_20px_2px_#36c318]  bg-[#bbecd2] font-semibold px-4 py-2 transition ring ring-green-400/20 rounded-xl"
                    href="{{ route('dashboard') }}">Reportes</a></li>
            <li class="transition hover:scale-95"><a
                    class="text-black hover:shadow-[1px_1px_20px_2px_#36c318]  bg-[#bbecd2] font-semibold px-4 py-2 transition ring ring-green-400/20 rounded-xl"
                    href="{{ route('events') }}">Eventos</a>
            </li>
            <li class="transition hover:scale-95"><a
                    class="text-black hover:shadow-[1px_1px_20px_2px_#36c318]  bg-[#bbecd2] font-semibold px-4 py-2 transition ring ring-green-400/20 rounded-xl"
                    href="{{ route('universities') }}">Universidades</a>
            </li>
            <li class="transition hover:scale-95"><a
                    class="text-black hover:shadow-[1px_1px_20px_2px_#36c318]  bg-[#bbecd2] font-semibold px-4 py-2 transition ring ring-green-400/20 rounded-xl"
                    href="{{ route('agreements') }}">Convenios</a></li>
            <li class="transition hover:scale-95"><a
                    class="text-black hover:shadow-[1px_1px_20px_2px_#36c318]  bg-[#bbecd2] font-semibold px-4 py-2 transition ring ring-green-400/20 rounded-xl"
                    href="{{ route('careers') }}">Programas</a></li>
            <li class="transition hover:scale-95"><a
                    class="text-black hover:shadow-[1px_1px_20px_2px_#36c318]  bg-[#bbecd2] font-semibold px-4 py-2 transition ring ring-green-400/20 rounded-xl"
                    href="{{ route('activities') }}">Actividades</a>
            </li>
        </nav>

        <form action="{{ route('logout') }}" class="flex items-center justify-center w-full sm:w-fit" method="POST">
            @csrf
            @method('POST')
            <button type="submit"
                class="px-4 py-3 sm:w-fit w-full font-semibold text-center text-white transition rounded-lg mx-7 bg-gradient-to-bl from-red-500 to-red-700 hover:shadow-[1px_1px_20px] hover:shadow-red-400/65 hover:bg-blend-darken hover:scale-95 ">Cerrar
                Sesión</button>
        </form>
    </header>

    <main class="w-full min-h-screen px-6 py-4 mx-4 bg-white rounded-md max-w-7xl sm:mx-auto">
        {{-- <div class="my-4">
            <h2 class="text-2xl font-semibold text-green-700">
                {{ $title }}
            </h2>
        </div> --}}
        {{ $slot }}
    </main>
</x-app-layout>
