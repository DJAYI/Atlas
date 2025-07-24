<x-app-layout>
    <div class="flex flex-col items-center justify-center min-h-screen px-4 py-12 bg-gray-50 sm:px-6 lg:px-8">
        <!-- Header with logos -->
        <div class="flex flex-col items-center justify-center mb-8 gap-x-3">
            <div class="flex items-center justify-center p-2">
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

        <!-- Main card -->
        <div class="w-full max-w-md">
            <div class="px-8 py-10 bg-white border border-gray-200 rounded-lg shadow-xl">
                <div class="mb-8 text-center">
                    <!-- Security icon -->
                    <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-full bg-primary-100">
                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                    </div>

                    <h2 class="text-2xl font-black text-gray-900 drop-shadow-md">
                        Verificación de Seguridad
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Ingresa el código de 6 dígitos enviado a
                    </p>
                    <p
                        class="inline-block px-3 py-1 mt-1 text-sm font-semibold rounded-full text-primary-600 bg-primary-50">
                        {{ session('pending_2fa_email') }}
                    </p>
                </div>

                <form id="verification-form" class="space-y-6" action="{{ route('2fa.verify') }}" method="POST">
                    @csrf

                    <!-- Code input -->
                    <div class="space-y-4">
                        <label for="verification_code" class="block text-sm font-medium text-center text-gray-700">
                            Código de Verificación
                        </label>
                        <div class="relative">
                            <input type="text" name="verification_code" id="verification_code" maxlength="6"
                                placeholder="••••••" required autofocus
                                class="block w-full px-4 py-4 text-center text-3xl font-mono tracking-[0.5em] border-2 border-gray-300 rounded-lg focus:ring-4 focus:ring-primary-400 focus:border-primary-500 transition-all duration-200 bg-gray-50">

                            <!-- Visual indicator -->
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <div id="input-indicator" class="hidden">
                                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        @error('verification_code')
                            <div class="flex items-center gap-2 p-3 border border-red-200 rounded-md bg-red-50">
                                <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <p class="text-sm text-red-700">{{ $message }}</p>
                            </div>
                        @enderror
                    </div>

                    <!-- Info banner -->
                    <div class="flex items-start gap-3 p-4 border border-blue-200 rounded-lg bg-blue-50">
                        <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <div class="text-sm text-blue-700">
                            <p class="font-medium">Información importante:</p>
                            <p class="mt-1">• Solo puede ser utilizado una vez</p>
                            <p>• Se enviará automáticamente al completar</p>
                            <p>• Revisa tu bandeja de entrada y spam</p>
                        </div>
                    </div>

                    <!-- Submit button -->
                    <button type="submit"
                        class="w-full px-4 py-3 text-lg font-semibold text-white transition rounded-lg bg-gradient-to-tr from-primary-500 to-secondary-500 hover:shadow-[1px_1px_20px] hover:shadow-primary-400/60 hover:from-primary-600 hover:to-secondary-600 focus:outline-none focus:ring-4 focus:ring-primary-400">
                        <span class="flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Verificar Código
                        </span>
                    </button>

                    @if (session('status'))
                        <div class="flex items-center gap-2 p-4 border border-green-200 rounded-lg bg-green-50">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <p class="text-sm font-medium text-green-700">{{ session('status') }}</p>
                        </div>
                    @endif
                </form>

                <!-- Footer actions -->
                <div class="pt-6 mt-8 space-y-4 border-t border-gray-200">
                    <div class="text-center">
                        <a href="{{ route('2fa.resend') }}"
                            class="inline-flex items-center gap-2 font-medium transition-colors text-primary-600 hover:text-primary-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                </path>
                            </svg>
                            ¿No recibiste el código? Reenviar
                        </a>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('home', ['locale' => app()->getLocale()]) }}"
                            class="inline-flex items-center gap-2 font-medium text-gray-600 transition-colors hover:text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Volver al inicio
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress indicator -->
        <div class="flex items-center justify-center mt-8 space-x-2">
            <div class="w-3 h-3 rounded-full bg-primary-600"></div>
            <div class="w-3 h-3 rounded-full bg-primary-300"></div>
            <div class="w-3 h-3 bg-gray-300 rounded-full"></div>
        </div>
        <p class="mt-2 text-sm text-center text-gray-500">Paso 2 de 3 - Verificación de seguridad</p>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const verificationCodeInput = document.getElementById('verification_code');
            const form = document.getElementById('verification-form');
            const indicator = document.getElementById('input-indicator');

            // Auto-focus en el campo del código
            verificationCodeInput.focus();

            // Solo permitir números y mejorar UX
            verificationCodeInput.addEventListener('input', function(e) {
                // Solo números
                this.value = this.value.replace(/[^0-9]/g, '');

                // Efectos visuales basados en la longitud
                if (this.value.length === 6) {
                    this.classList.add('bg-green-50', 'border-green-500', 'ring-4', 'ring-green-400/50');
                    this.classList.remove('bg-gray-50', 'border-gray-300');
                    indicator.classList.remove('hidden');

                    // Auto-submit con animación
                    setTimeout(() => {
                        form.submit();
                    }, 500);
                } else if (this.value.length > 0) {
                    this.classList.add('bg-blue-50', 'border-primary-400');
                    this.classList.remove('bg-gray-50', 'border-gray-300', 'bg-green-50',
                        'border-green-500', 'ring-4', 'ring-green-400/50');
                    indicator.classList.add('hidden');
                } else {
                    this.classList.add('bg-gray-50', 'border-gray-300');
                    this.classList.remove('bg-blue-50', 'border-primary-400', 'bg-green-50',
                        'border-green-500', 'ring-4', 'ring-green-400/50');
                    indicator.classList.add('hidden');
                }
            });

            // Animación de entrada suave
            const card = document.querySelector('.bg-white');
            card.style.transform = 'translateY(20px)';
            card.style.opacity = '0';

            setTimeout(() => {
                card.style.transition = 'all 0.5s ease-out';
                card.style.transform = 'translateY(0)';
                card.style.opacity = '1';
            }, 100);

            // Prevenir submit accidental con Enter antes de 6 dígitos
            form.addEventListener('submit', function(e) {
                if (verificationCodeInput.value.length !== 6) {
                    e.preventDefault();
                    verificationCodeInput.focus();
                    verificationCodeInput.classList.add('ring-4', 'ring-red-400/50', 'border-red-500');
                    setTimeout(() => {
                        verificationCodeInput.classList.remove('ring-4', 'ring-red-400/50',
                            'border-red-500');
                    }, 1000);
                }
            });
        });
    </script>
</x-app-layout>
