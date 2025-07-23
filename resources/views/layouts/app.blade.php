<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>


    {{-- Choice.JS --}}
    <!-- Agregar el archivo CSS (aunque no vamos a usar los estilos, es requerido para un funcionamiento adecuado) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">

    <!-- Agregar el archivo JS de Choices.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

    {{-- Singlemaps --}}
    @if (file_exists(resource_path('js/mapdata.js')))
        <script type="text/javascript" src="{{ asset('js/mapdata.js') }}" defer></script>
    @endif
    @if (file_exists(resource_path('js/worldmap.js')))
        <script type="text/javascript" src="{{ asset('js/worldmap.js') }}" defer></script>
    @endif

    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" defer></script>



    {{-- Livewire --}}
    @livewireStyles
</head>

<body class="overflow-y-auto font-sans antialiased">
    <div class="flex flex-col min-h-screen">
        <div class="fixed w-full h-screen bg-white -z-50">
            {{-- Sphere gadient in the background with secondary color positionated down and left --}}

            <div
                class="absolute rounded-full size-[700px] bg-gradient-to-bl from-primary-400 to-primary-600 filter blur-[100px] opacity-20 -left-60 -top-20">
            </div>

            <div class="absolute w-full h-full rounded-full opacity-60">

                <img class="object-cover w-full h-full transition-opacity duration-500 ease-in-out opacity-0 brightness-110"
                    src="{{ asset('images/background_layout.jpg') }}" alt="" loading="lazy"
                    onload="this.style.opacity='1'">
            </div>
        </div>
        <!-- Page Content -->
        <main class="flex-grow ">
            {{ $slot }}
        </main>

        <!-- Toast notifications -->
        @if (session('toast'))
            <x-toast type="{{ session('toast.type') }}" message="{{ session('toast.message') }}" />
        @endif

        @if (session('success'))
            <x-toast type="success" message="{{ session('success') }}" />
        @endif

        @if (session('error'))
            <x-toast type="error" message="{{ session('error') }}" />
        @endif

        @if (session('warning'))
            <x-toast type="warning" message="{{ session('warning') }}" />
        @endif

        @if (session('info'))
            <x-toast type="info" message="{{ session('info') }}" />
        @endif

    </div>


    @livewireScripts

    @stack('scripts')

</body>

</html>
