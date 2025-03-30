@props(['title' => 'Sistema de Internacionalización de Eventos'])

<x-app-layout>
    <header style="view-transition-name: dashboard-header"
        class="flex flex-col items-center justify-between w-full gap-5 px-4 py-3 bg-white/90 sm:flex-row">
        <div class="flex items-center justify-between gap-6">
            <h1 class="text-3xl font-black text-primary-700">Hermes</h1>
            <button
                class="p-2 transition sm:hidden outline outline-primary-300 hover:outline-4 hover:outline-primary-400 hover:shadow-md hover:shadow-primary-200 rounded-xl hover:ring-8 hover:ring-primary-200 "
                id="menu-btn">
                @php
                    $menuIcon = public_path('icons/bars-menu.svg');
                    echo file_get_contents($menuIcon);
                @endphp
            </button>
        </div>

        <nav id="menu" class="flex flex-col md:flex-row [&>*]:list-none items-center gap-5 rounded-xl p-4">
            <li class="transition hover:scale-95">
                <a class="text-black font-semibold px-4 py-2 transition ring ring-primary-200/20 rounded-xl bg-primary-50 hover:shadow-[1px_1px_20px_2px_#80b1ff] {{ request()->routeIs('dashboard') ? 'shadow-[1px_1px_20px_2px_#80b1ff] scale-95' : '' }}"
                    href="{{ route('dashboard') }}">Reportes</a>
            </li>
            <li class="transition hover:scale-95">
                <a class="text-black font-semibold px-4 py-2 transition ring ring-primary-200/20 rounded-xl bg-primary-50 hover:shadow-[1px_1px_20px_2px_#80b1ff] {{ request()->routeIs('events') ? 'shadow-[1px_1px_20px_2px_#80b1ff] scale-95' : '' }}"
                    href="{{ route('events') }}">Eventos</a>
            </li>
            <li class="transition hover:scale-95">
                <a class="text-black font-semibold px-4 py-2 transition ring ring-primary-200/20 rounded-xl bg-primary-50 hover:shadow-[1px_1px_20px_2px_#80b1ff] {{ request()->routeIs('universities') ? 'shadow-[1px_1px_20px_2px_#80b1ff] scale-95' : '' }}"
                    href="{{ route('universities') }}">Universidades</a>
            </li>
            <li class="transition hover:scale-95">
                <a class="text-black font-semibold px-4 py-2 transition ring ring-primary-200/20 rounded-xl bg-primary-50 hover:shadow-[1px_1px_20px_2px_#80b1ff] {{ request()->routeIs('agreements') ? 'shadow-[1px_1px_20px_2px_#80b1ff] scale-95' : '' }}"
                    href="{{ route('agreements') }}">Convenios</a>
            </li>
            <li class="transition hover:scale-95">
                <a class="text-black font-semibold px-4 py-2 transition ring ring-primary-200/20 rounded-xl bg-primary-50 hover:shadow-[1px_1px_20px_2px_#80b1ff] {{ request()->routeIs('careers') ? 'shadow-[1px_1px_20px_2px_#80b1ff] scale-95' : '' }}"
                    href="{{ route('careers') }}">Programas</a>
            </li>
            <li class="transition hover:scale-95">
                <a class="text-black font-semibold px-4 py-2 transition ring ring-primary-200/20 rounded-xl bg-primary-50 hover:shadow-[1px_1px_20px_2px_#80b1ff] {{ request()->routeIs('activities') ? 'shadow-[1px_1px_20px_2px_#80b1ff] scale-95' : '' }}"
                    href="{{ route('activities') }}">Actividades</a>
            </li>
        </nav>

        <form action="{{ route('logout') }}" class="flex items-center justify-center w-full sm:w-fit" method="POST">
            @csrf
            @method('POST')
            <button type="submit"
                class="px-4 py-3 sm:w-fit w-full font-semibold text-center text-white transition rounded-lg mx-7 bg-gradient-to-bl from-secondary-400 to-secondary-600 hover:shadow-[1px_1px_20px] hover:shadow-secondary-400/65 hover:bg-blend-darken hover:scale-95 ">Cerrar
                Sesión</button>
        </form>
    </header>

    <main
        class="flex flex-col justify-between w-full min-h-screen px-6 py-4 mx-4 bg-white rounded-md max-w-7xl sm:mx-auto">

        <div>
            {{ $slot }}
        </div>

        <footer class="flex flex-col items-center justify-center w-full px-6 py-4 bg-white ">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQtxW4Gq4oqpJmqr-vrf2VR-Kjo_lTh7vFtDA&s"
                class="h-16" alt="">
            <p class="text-gray-500">2025 &copy; Copyright - Fundación Universitaria Tecnológico Comfenalco</p>
        </footer>

    </main>

</x-app-layout>
