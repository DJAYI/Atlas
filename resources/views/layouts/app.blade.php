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

    {{-- Choice.JS --}}
    <!-- Agregar el archivo CSS (aunque no vamos a usar los estilos, es requerido para un funcionamiento adecuado) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">

    <!-- Agregar el archivo JS de Choices.js -->
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen">
        <div class="fixed w-full h-screen bg-gradient-to-bl from-white to-green-200 -z-50"></div>
        <!-- Page Content -->
        <main class="">
            {{ $slot }}
        </main>
    </div>
</body>

</html>
