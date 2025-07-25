<x-app-layout>
    <div class="flex flex-col items-center justify-around sm:flex-row">
        <div class="flex flex-col items-center justify-center gap-x-3 sm:flex-row">
            <div class="flex items-center justify-center p-2 mb-4 sm:mb-0">
                <img src="{{ asset('images/logo_tecno_comfenalco.png') }}" onload="this.classList.add('opacity-100')"
                    class="object-contain w-24 transition-opacity opacity-0 aspect-video" alt="">
                <hr class="h-16 w-[2px] bg-gradient-to-tr from-primary-400 to-secondary-300 rotate-12 mx-4">
                <img loading="lazy" src="{{ asset('images/wonderlust_logo.webp') }}"
                    onload="this.classList.add('opacity-100')"
                    class="object-contain transition-opacity opacity-0 w-14 mix-blend-multiply brightness-105 aspect-square"
                    alt="">
            </div>
            <h1 class="text-3xl font-black text-primary-700">Wonderlust</h1>
        </div>

        <x-utils.language-selector route="home" />
    </div>

    <div
        class="grid w-full mb-6  sm:h-dvh grid-cols-1 gap-5 mx-auto md:grid-cols-[1fr_4px_1fr] max-w-7xl sm:place-items-center items-start">
        <div class="flex flex-col justify-center gap-4 mt-8">
            <h1 class="text-5xl font-black text-center sm:hidden drop-shadow-md ">{{ __('Bienvenido a') }} <span
                    class="text-secondary-400">Wonderlust</span></h1>
            <h1 class="text-3xl font-black text-center drop-shadow-md ">
                {{ __('¿Éres un Asistente?') }}</h1>

            <img src="{{ asset('images/map-destination.png') }}"
                class="object-cover sm:mx-auto transition-opacity duration-500 ease-in-out bg-transparent opacity-0 brightness-110 aspect-square mx-4 sm:w-[500px] "
                alt="" loading="lazy"
                style="clip-path: polygon(47% 3%, 90% 4%, 100% 43%, 100% 70%, 98% 96%, 7% 100%, 0 58%, 12% 40%, 8% 31%, 11% 23%); mask-image: linear-gradient(to top, transparent 2%, black 60%);"
                onload="this.style.opacity='1'">
            <a href="{{ route('assistance', ['locale' => app()->getLocale()]) }}"
                class="block sm:inline-block mx-5 sm:w-3/5 sm:mx-auto px-4 py-3 font-semibold text-center text-white transition rounded-lg  bg-gradient-to-tr from-blue-500 to-blue-700 hover:shadow-[1px_1px_20px] hover:shadow-blue-400/65 hover:bg-blend-darken hover:bg-primary-500 ">{{ __('Registra tu Asistencia') }}</a>
        </div>
        <div class="flex-col items-center justify-center hidden gap-4 md:flex">
            <hr class="h-56 w-[3px] bg-gradient-to-t from-primary-300 to-transparent">
            {{ __('O') }}
            <hr class="h-56 w-[3px] bg-gradient-to-b from-secondary-300 to-transparent">
        </div>
        <div class="flex-col justify-center hidden gap-4 mx-4 sm:flex">
            <h1 class="hidden text-5xl font-black text-center sm:block drop-shadow-md ">{{ __('Bienvenido a') }} <span
                    class="text-secondary-400">Wonderlust</span></h1>

            <h1 class="text-3xl font-black text-center sm:hidden drop-shadow-md ">
                {{ __('¿Éres un Gestor?') }} <br> {{ __('Inicia Sesión') }}</h1>

            <form action="{{ route('login') }}" id="login-form" class="flex flex-col gap-6" method="POST">
                @csrf
                @method('POST')

                <h3 class="text-2xl mb-4 hidden md:block text-pretty max-w-[450px]">
                    {{ __('¿Vas a gestionar tu internacionalización?') }}
                </h3>

                <div class="flex flex-col gap-4 mt-4">

                    <div class="flex flex-col gap-2">
                        <label for="email" class="text-lg">{{ __('Correo electrónico') }}</label>
                        <input id="email" type="email" name="email" minlength="8" maxlength="254" required
                            autofocus autocomplete="username"
                            class="px-4 py-3 transition border-none rounded-md ring-2 focus:ring-4 focus:ring-primary-400 ring-primary-300">

                        @error('email')
                            <p class="text-sm text-red-500 text-pretty">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="password" class="text-lg">{{ __('Contraseña') }}</label>
                        <input type="password" name="password" required autocomplete="current-password"
                            class="px-4 py-3 transition border-none rounded-md ring-2 focus:ring-4 focus:ring-primary-400 ring-primary-300">

                        @error('password')
                            <p class="text-sm text-red-500 text-pretty">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="cf-turnstile" data-sitekey={{ config('services.turnstile.site_key') }}></div>

                    @error('cf-turnstile-response')
                        <p class="text-sm text-red-500 text-pretty">{{ $message }}</p>
                    @enderror

                    <button type="submit"
                        class="px-4 mt-4 py-3 text-lg font-semibold text-white transition bg-secondary-500 rounded-md hover:shadow-[1px_1px_20px] bg-gradient-to-tr to-secondary-500 from-primary-500 hover:shadow-primary-400/60 bg-blend-lighten hover:bg-secondary-400">{{ __('Iniciar sesión') }}</button>
                </div>
            </form>

        </div>
    </div>

    <footer class="sticky flex flex-col items-center justify-between w-full gap-4 px-6 py-4 bg-transparent sm:flex-row">
        <img src="{{ asset('images/logo_tecno_comfenalco.png') }}" class="max-h-24 aspect-video" alt="">
        <p class="self-end font-semibold text-center text-black sm:text-start">
            2025 &copy; Copyright - Fundación Universitaria Tecnológico Comfenalco
        </p>
    </footer>
</x-app-layout>
