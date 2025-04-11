<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">


    {{-- Choice.JS --}}
    <!-- Agregar el archivo CSS (aunque no vamos a usar los estilos, es requerido para un funcionamiento adecuado) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">

    <!-- Agregar el archivo JS de Choices.js -->
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    @livewireStyles
</head>

<body class="font-sans antialiased overflow-y-auto">
    <div class="min-h-screen flex flex-col">
        <div class="fixed w-full h-screen bg-white -z-50">
            {{-- Sphere gadient in the background with secondary color positionated down and left --}}

            <div
                class="absolute rounded-full size-[700px] bg-gradient-to-bl from-primary-400 to-primary-600 filter blur-[100px] opacity-20 -left-60 -top-20">
            </div>

            <div class="absolute rounded-full h-full w-full opacity-60">

                <img class="w-full h-full opacity-0 transition-opacity duration-500 ease-in-out brightness-110 object-cover"
                    src="{{ asset('images/background_layout.jpg') }}" alt="" loading="lazy"
                    onload="this.style.opacity='1'">
            </div>
        </div>
        <!-- Page Content -->
        <main class=" flex-grow ">
            {{ $slot }}
        </main>

    </div>

    @livewireScripts

</body>

</html>
