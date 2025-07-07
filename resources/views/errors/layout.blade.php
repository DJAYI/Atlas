<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Error' }} | {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
</head>

<body class="font-sans antialiased">
    <div class="flex flex-col min-h-screen">
        <div class="fixed w-full h-screen bg-white -z-50">
            {{-- Sphere gradient in the background with primary color positioned down and left --}}
            <div
                class="absolute rounded-full size-[700px] bg-gradient-to-bl from-primary-400 to-primary-600 filter blur-[100px] opacity-20 -left-60 -top-20">
            </div>
        </div>

        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="text-center">
                <div class="flex justify-center mb-6">
                    <img loading="lazy" src="{{ asset('images/wonderlust_logo.webp') }}" class="h-24 brightness-105"
                        alt="Wonderlust">
                </div>

                <div class="max-w-md p-6 mx-auto bg-white border-t-4 rounded-lg shadow-lg md:p-8 border-primary-500">
                    <div class="mb-4 font-bold text-7xl text-primary-600">{{ $errorCode }}</div>
                    <h1 class="mb-2 text-2xl font-bold text-gray-800">{{ $title }}</h1>
                    <p class="mb-6 text-gray-600">{{ $message }}</p>

                    <div class="mt-6">
                        <a href="{{ route('home', ['locale' => app()->getLocale() ?: 'es']) }}"
                            class="px-5 py-3 text-white transition bg-gradient-to-tr from-blue-500 to-blue-700 rounded-lg hover:shadow-[1px_1px_20px] hover:shadow-blue-400/65">
                            Volver al inicio
                        </a>
                    </div>
                </div>

                <div class="mt-8">
                    <img src="{{ asset('images/logo_tecno_comfenalco.png') }}" class="h-16 mx-auto"
                        alt="Tecnológico Comfenalco">
                </div>
            </div>
        </div>
    </div>
</body>

</html>
