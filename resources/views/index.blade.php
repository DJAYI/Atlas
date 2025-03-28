<x-app-layout>
    <x-utils.language-selector route="home" />

    <div class="grid w-full h-screen grid-cols-1 gap-5 mx-auto md:grid-cols-[1fr_4px_1fr] max-w-7xl place-items-center">
        <div class="flex flex-col justify-center gap-4">
            <h1 class="text-3xl font-black text-center drop-shadow-md ">
                {{ __('¿Éres un Asistente?') }}</h1>

            <img src="{{ asset('images/wait.png') }}"
                class="object-cover brightness-110 mix-blend-multiply w-3/4 mx-auto aspect-square" alt="">
            <a href="{{ route('assistance', ['locale' => app()->getLocale()]) }}"
                class="inline-block w-3/5 mx-auto px-4 py-3 font-semibold text-center text-white transition rounded-lg  bg-gradient-to-tr from-blue-500 to-blue-700 hover:shadow-[1px_1px_20px] hover:shadow-blue-400/65 hover:bg-blend-darken hover:scale-95 ">{{ __('Registra tu Asistencia') }}</a>
        </div>
        <div class="flex-col items-center justify-center hidden gap-4 md:flex">
            <hr class="h-56 border-r-2 border-green-300">
            {{ __('O') }}
            <hr class="h-56 border-r-2 border-green-300">
        </div>
        <div class="flex flex-col justify-center gap-4">
            <h1 class="text-5xl font-black text-center drop-shadow-md ">{{ __('Bienvenido a Hermes') }}</h1>

            <form action="{{ route('login') }}" class="flex flex-col gap-6" method="POST">
                @csrf
                @method('POST')

                <h3 class="text-2xl text-pretty max-w-[450px]">{{ __('¿Vas a gestionar tu internacionalización?') }}
                </h3>

                <div class="flex flex-col gap-4">

                    <div class="flex flex-col gap-2">
                        <label for="email" class="text-lg">{{ __('Correo electrónico') }}</label>
                        <input id="email" type="email" name="email" required autofocus autocomplete="username"
                            class="px-4 py-3 transition border-none rounded-md ring-2 focus:ring-4 focus:ring-green-400 ring-green-300">
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="password" class="text-lg">{{ __('Contraseña') }}</label>
                        <input type="password" name="password" required autocomplete="current-password"
                            class="px-4 py-3 transition border-none rounded-md ring-2 focus:ring-4 focus:ring-green-400 ring-green-300">
                    </div>

                    <button type="submit"
                        class="px-4 mt-4 py-3 text-lg font-semibold text-white transition bg-blue-500 rounded-md hover:shadow-[1px_1px_20px] bg-gradient-to-tr from-blue-500 to-green-500 hover:shadow-green-400/60 hover:bg-blend-darken">{{ __('Iniciar sesión') }}</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
