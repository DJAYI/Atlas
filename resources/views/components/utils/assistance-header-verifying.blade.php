<nav class="flex flex-col gap-4 p-6 mb-3 md:flex-row md:items-center">
    <li class="list-none w-fit">
        <a class="flex flex-row items-center gap-1 px-4 py-2 text-lg font-semibold transition rounded-md shadow-xl group shadow-transparent hover:shadow-red-300 ring-1 hover:ring-4 ring-red-300 hover:text-white w-fit hover:bg-red-500"
            href="{{ route('home', ['locale' => 'es']) }}">

            <img class="transition group-hover:filter group-hover:-translate-x-2 group-hover:brightness-0 group-hover:invert"
                src="{{ asset('icons/back-arrow.svg') }}" alt="Back Arrow Icon" />
            <span class="transition group-hover:-translate-x-1">{{ __('Volver') }}</span>
        </a>
    </li>

    <li class="w-full list-none md:w-2/5 md:mx-3">
        <span>
            <h1 class="text-2xl font-black sm:text-3xl drop-shadow-md ">
                {{ __('Verifíca tu Asistencia') }}
            </h1>
        </span>
    </li>
</nav>

<form id="verify-assistance-form" action="{{ route('assistance.verify', ['locale' => app()->getLocale()]) }}"
    class="flex flex-col items-center" method="POST">
    @csrf
    @method('POST')

    <div class="flex flex-col items-center justify-center w-full md:flex-row">

        {{-- Tipo de documento --}}
        <div class="flex flex-col w-full gap-4 px-6 md:py-4">
            <label for="document_type" class="text-lg font-semibold text-gray-700">
                {{ __('Tipo de documento') }} <span class="text-secondary-400">*</span>
            </label>
            <select name="document_type" id="document_type" required
                class="w-full px-4 py-2 transition bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-primary-300">
                <option value="" disabled {{ old('document_type', session('document_type')) ? '' : 'selected' }}>
                    {{ __('Seleccione un tipo de documento') }}
                </option>
                @php
                    $documentTypes = [
                        'DNI' => 'DNI',
                        'PP' => 'Pasaporte',
                        'CC' => 'Cédula de Ciudadanía',
                        'CE' => 'Cedula de Extranjería',
                        'TI' => 'Tarjeta de Identidad',
                        'CA' => 'Certificado Cabildo',
                        'Otro' => 'Otro',
                    ];
                @endphp
                @foreach ($documentTypes as $key => $label)
                    <option value="{{ $key }}"
                        {{ old('document_type', session('document_type')) == $key ? 'selected' : '' }}>
                        {{ __($label) }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Número de documento --}}
        <div class="flex flex-col w-full gap-4 p-6">
            <label for="document_number" class="text-lg font-semibold text-gray-700">
                {{ __('Número de Documento') }} <span class="text-secondary-400">*</span>
            </label>
            <input type="text" name="document_number" id="document_number" required
                class="w-full px-4 py-2 transition bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-primary-300"
                placeholder="{{ __('Ingrese su Número de Documento') }}"
                value="{{ old('document_number', session('document_number')) }}">
        </div>

        {{-- Código del evento --}}
        <div class="flex flex-col w-full gap-4 p-6">
            <label for="event_code" class="text-lg font-semibold text-gray-700">
                {{ __('Código del Evento') }} <span class="text-secondary-400">*</span>
            </label>
            <input type="text" id="event_code" name="event_code" required
                class="w-full px-4 py-2 transition bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-primary-300"
                placeholder="{{ __('Ingrese el código del evento') }}"
                value="{{ old('event_code', session('event_code')) }}">
        </div>
    </div>

    <div class="flex flex-col justify-between w-full gap-4 px-6 py-4 mt-4 bg-white rounded-lg md:flex-row">
        <div class="cf-turnstile" data-sitekey={{ config('services.turnstile.site_key') }}
            data-response-field-name="cf-turnstile-response"></div>

        {{-- Botón de búsqueda --}}
        <button type="submit"
            class="self-end px-4 py-2 mx-12 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl from-primary-500 to-primary-700 hover:scale-95">
            {{ __('Buscar Coincidencias') }}
        </button>
    </div>
    {{-- Display validation errors --}}
    @if ($errors->any())
        <div class="w-full p-4 my-4 text-red-700 bg-red-100 border border-red-400">
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="flex items-center gap-2"> <span class="block w-2 h-2 p-1 bg-red-500 rounded-full"></span>
                        {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Mensaje de éxito si el evento fue encontrado --}}
    @if (session('success'))
        <div class="w-full p-4 my-4 text-green-700 bg-green-100 border border-green-400">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="w-full p-4 my-4 text-red-700 bg-red-100 border border-red-400">
            {{ session('error') }}
        </div>
    @endif
</form>
