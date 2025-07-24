@props(['title' => 'Sistema de Internacionalización de Eventos'])

<x-app-layout>
    <header style="view-transition-name: dashboard-header"
        class="flex flex-col items-center justify-between w-full gap-3 px-3 py-3 bg-white/90 lg:flex-row lg:gap-4 min-h-[80px]">
        <div class="flex flex-col items-center justify-center gap-x-2 lg:flex-row shrink-0">
            <div class="flex items-center justify-center p-1 mb-1 lg:mb-0">
                <img src="{{ asset('images/logo_tecno_comfenalco.png') }}"
                    class="object-contain w-16 lg:w-20 aspect-video" alt="">
                <hr
                    class="h-10 lg:h-12 w-[2px] bg-gradient-to-tr from-primary-400 to-secondary-300 rotate-12 mx-2 lg:mx-3">
                <img loading="lazy" src="{{ asset('images/wonderlust_logo.webp') }}"
                    class="object-contain w-10 lg:w-12 mix-blend-multiply brightness-105 aspect-square" alt="">
            </div>
            <h1 class="text-xl font-black lg:text-2xl text-primary-700 whitespace-nowrap">Wonderlust</h1>
        </div>

        <nav id="menu"
            class="flex flex-wrap justify-center lg:flex-nowrap [&>*]:list-none items-center gap-1 gap-x-4 lg:gap-2 rounded-xl p-1 lg:p-2 w-full lg:w-auto">
            @can('access dashboard')
                @role('auxiliar')
                    {{-- No mostrar el enlace de Reportes para el rol auxiliar --}}
                @else
                    <li class="transition hover:scale-95">
                        <a class="text-black font-semibold px-2 lg:px-3 py-1.5 lg:py-2 text-xs lg:text-sm transition ring ring-primary-200/20 rounded-lg bg-primary-50 hover:shadow-[1px_1px_15px_1px_#80b1ff] whitespace-nowrap {{ request()->routeIs('dashboard') ? 'bg-primary-500 text-white scale-95' : '' }}"
                            href="{{ route('dashboard') }}">Reportes</a>
                    </li>
                @endrole
            @endcan

            @canany(['view events', 'create events', 'edit events'])
                <li class="transition hover:scale-95">
                    <a class="text-black font-semibold px-2 lg:px-3 py-1.5 lg:py-2 text-xs lg:text-sm transition ring ring-primary-200/20 rounded-lg bg-primary-50 hover:shadow-[1px_1px_15px_1px_#80b1ff] whitespace-nowrap {{ request()->routeIs('events') ? 'bg-primary-500 text-white scale-95' : '' }}"
                        href="{{ route('events') }}">Eventos</a>
                </li>
            @endcanany

            @canany(['view universities', 'create universities', 'edit universities'])
                <li class="transition hover:scale-95">
                    <a class="text-black font-semibold px-2 lg:px-3 py-1.5 lg:py-2 text-xs lg:text-sm transition ring ring-primary-200/20 rounded-lg bg-primary-50 hover:shadow-[1px_1px_15px_1px_#80b1ff] whitespace-nowrap {{ request()->routeIs('universities') ? 'bg-primary-500 text-white scale-95' : '' }}"
                        href="{{ route('universities') }}">Universidades</a>
                </li>
            @endcanany

            @canany(['view agreements', 'create agreements', 'edit agreements'])
                <li class="transition hover:scale-95">
                    <a class="text-black font-semibold px-2 lg:px-3 py-1.5 lg:py-2 text-xs lg:text-sm transition ring ring-primary-200/20 rounded-lg bg-primary-50 hover:shadow-[1px_1px_15px_1px_#80b1ff] whitespace-nowrap {{ request()->routeIs('agreements') ? 'bg-primary-500 text-white scale-95' : '' }}"
                        href="{{ route('agreements') }}">Convenios</a>
                </li>
            @endcanany

            @canany(['view programs', 'create programs', 'edit programs'])
                <li class="transition hover:scale-95">
                    <a class="text-black font-semibold px-2 lg:px-3 py-1.5 lg:py-2 text-xs lg:text-sm transition ring ring-primary-200/20 rounded-lg bg-primary-50 hover:shadow-[1px_1px_15px_1px_#80b1ff] whitespace-nowrap {{ request()->routeIs('careers') ? 'bg-primary-500 text-white scale-95' : '' }}"
                        href="{{ route('careers') }}">Programas</a>
                </li>
            @endcanany

            @canany(['view activities', 'create activities', 'edit activities'])
                <li class="transition hover:scale-95">
                    <a class="text-black font-semibold px-2 lg:px-3 py-1.5 lg:py-2 text-xs lg:text-sm transition ring ring-primary-200/20 rounded-lg bg-primary-50 hover:shadow-[1px_1px_15px_1px_#80b1ff] whitespace-nowrap {{ request()->routeIs('activities') ? 'bg-primary-500 text-white scale-95' : '' }}"
                        href="{{ route('activities') }}">Actividades</a>
                </li>
            @endcanany

            @can('manage users')
                <li class="transition hover:scale-95">
                    <a class="text-black font-semibold px-2 lg:px-3 py-1.5 lg:py-2 text-xs lg:text-sm transition ring ring-primary-200/20 rounded-lg bg-primary-50 hover:shadow-[1px_1px_15px_1px_#80b1ff] whitespace-nowrap {{ request()->routeIs('users') ? 'bg-primary-500 text-white scale-95' : '' }}"
                        href="{{ route('users') }}">Usuarios</a>
                </li>
            @endcan
        </nav>

        <form action="{{ route('logout') }}" class="flex items-center justify-center w-full lg:w-fit shrink-0"
            method="POST">
            @csrf
            @method('POST')
            <button type="submit"
                class="px-3 lg:px-4 py-1.5 lg:py-2 w-full lg:w-fit font-semibold text-center text-white text-xs lg:text-sm transition rounded-lg bg-gradient-to-bl from-secondary-400 to-secondary-600 hover:shadow-[1px_1px_15px] hover:shadow-secondary-400/65 hover:bg-blend-darken hover:scale-95 whitespace-nowrap min-w-[100px] lg:min-w-[110px]">Cerrar
                Sesión</button>
        </form>
    </header>

    <main
        class="flex flex-col justify-between w-full min-h-screen gap-4 px-6 py-4 mx-4 bg-white rounded-md max-w-7xl sm:mx-auto">

        <div>
            {{ $slot }}
        </div>

        <footer class="flex flex-col items-center justify-center w-full px-6 py-4 bg-white ">
            <img loading="lazy" src="{{ asset('images/logo_tecno_comfenalco.png') }}" class="h-24" alt="">
            <p class="text-gray-500">2025 &copy; Copyright - Fundación Universitaria Tecnológico Comfenalco</p>
        </footer>

    </main>

</x-app-layout>
