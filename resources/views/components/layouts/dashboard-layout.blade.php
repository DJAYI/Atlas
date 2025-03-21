@props(['title' => 'Sistema de Internacionalización de Eventos'])

<x-app-layout>
    <header class="flex flex-col bg-white/90 sm:flex-row  gap-5 items-center justify-between w-full px-4 py-3">
        <div class="flex items-center justify-between gap-6">
            <h1 class="text-3xl font-black text-green-700">Hermes</h1>
            <button
                class="sm:hidden p-2 outline outline-green-300 hover:outline-4 transition hover:outline-green-400 hover:shadow-md hover:shadow-green-200 rounded-xl hover:ring-8 hover:ring-green-200 "
                id="menu-btn">
                @php
                    $menuIcon = public_path('icons/bars-menu.svg');
                    echo file_get_contents($menuIcon);
                @endphp
            </button>
        </div>

        <nav id="menu" class="flex flex-col md:flex-row [&>*]:list-none items-center gap-5 rounded-xl p-4">
            <li class="hover:scale-95 transition"><a
                    class="text-black hover:shadow-[1px_1px_20px_2px_#36c318]  bg-[#bbecd2] font-semibold px-4 py-2 transition ring ring-green-400/20 rounded-xl"
                    href="{{ route('events') }}">Eventos</a>
            </li>
            <li class="hover:scale-95 transition"><a
                    class="text-black hover:shadow-[1px_1px_20px_2px_#36c318]  bg-[#bbecd2] font-semibold px-4 py-2 transition ring ring-green-400/20 rounded-xl"
                    href="">Calendario</a></li>
            <li class="hover:scale-95 transition"><a
                    class="text-black hover:shadow-[1px_1px_20px_2px_#36c318]  bg-[#bbecd2] font-semibold px-4 py-2 transition ring ring-green-400/20 rounded-xl"
                    href="">Reportes</a></li>
            <li class="hover:scale-95 transition"><a
                    class="text-black hover:shadow-[1px_1px_20px_2px_#36c318]  bg-[#bbecd2] font-semibold px-4 py-2 transition ring ring-green-400/20 rounded-xl"
                    href="">Universidades</a>
            </li>
            <li class="hover:scale-95 transition"><a
                    class="text-black hover:shadow-[1px_1px_20px_2px_#36c318]  bg-[#bbecd2] font-semibold px-4 py-2 transition ring ring-green-400/20 rounded-xl"
                    href="">Convenios</a></li>
            <li class="hover:scale-95 transition"><a
                    class="text-black hover:shadow-[1px_1px_20px_2px_#36c318]  bg-[#bbecd2] font-semibold px-4 py-2 transition ring ring-green-400/20 rounded-xl"
                    href="">Programas</a></li>
            <li class="hover:scale-95 transition"><a
                    class="text-black hover:shadow-[1px_1px_20px_2px_#36c318]  bg-[#bbecd2] font-semibold px-4 py-2 transition ring ring-green-400/20 rounded-xl"
                    href="">Mapa</a>
            </li>
        </nav>

        <form action="{{ route('logout') }}" class="w-full sm:w-fit flex justify-center items-center" method="POST">
            @csrf
            @method('POST')
            <button type="submit"
                class="px-4 py-3 sm:w-fit w-full font-semibold text-center text-white transition rounded-lg mx-7 bg-gradient-to-bl from-red-500 to-red-700 hover:shadow-[1px_1px_20px] hover:shadow-red-400/65 hover:bg-blend-darken hover:scale-95 ">Cerrar
                Sesión</button>
        </form>
    </header>

    <main class="px-6 py-4 bg-white rounded-md max-w-7xl w-full mx-4 sm:mx-auto h-screen">
        {{-- <div class="my-4">
            <h2 class="text-2xl font-semibold text-green-700">
                {{ $title }}
            </h2>
        </div> --}}
        {{ $slot }}
    </main>
</x-app-layout>
