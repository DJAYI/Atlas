<x-app-layout>
    <header class="flex items-center justify-between w-full px-4 py-3">
        <h1 class="text-3xl font-black text-green-700">Hermes</h1>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            @method('POST')
            <button type="submit"
                class="px-4 py-3 font-semibold text-center text-white transition rounded-lg mx-7 bg-gradient-to-bl from-red-500 to-red-700 hover:shadow-[1px_1px_20px] hover:shadow-red-400/65 hover:bg-blend-darken hover:scale-95 ">Cerrar
                Sesión</button>
        </form>
    </header>
</x-app-layout>
