<x-app-layout>
    <x-utils.language-selector route="assistance" />

    <div
        class="grid mt-2 w-auto min-h-screen grid-cols-1 grid-rows-[100px_1fr] gap-5 mx-auto bg-white sm:max-w-5xl rounded-t-xl md:grid-cols-1 ">

        <nav class="flex flex-row items-center gap-4 p-6">
            <li class="list-none w-fit">
                <a class="flex flex-row items-center gap-1 px-4 py-2 text-lg font-semibold transition rounded-md shadow-xl group shadow-transparent hover:shadow-red-300 ring-1 hover:ring-4 ring-red-300 hover:text-white w-fit hover:bg-red-500"
                    href="{{ route('home', ['locale' => 'es']) }}">
                    <span class="transition group-hover:scale-110 group-hover:-translate-x-2">
                        @php
                            $menuIcon = public_path('icons/back-arrow.svg');
                            echo file_get_contents($menuIcon);
                        @endphp
                    </span>
                    <span class="transition group-hover:-translate-x-1">{{ __('Volver') }}</span>
                </a>
            </li>

            <li class="w-2/5 mx-3 list-none">
                <span>
                    <h1 class="text-3xl font-black drop-shadow-md ">
                        {{ __('Registra tu Asistencia') }}
                    </h1>
                </span>
            </li>
        </nav>

        <form action="{{ route('assistance.verify', ['locale' => app()->getLocale()]) }}"
            class="flex flex-col items-center" method="POST">
            @csrf
            @method('POST')

            <div class="flex flex-row items-center justify-center w-full px-6">
                {{-- Tipo de documento --}}
                <div class="flex flex-col w-full gap-4 p-6">
                    <label for="document_type" class="text-lg font-semibold text-gray-700">
                        {{ __('Tipo de documento') }}
                    </label>
                    <select name="document_type" id="document_type" required
                        class="w-full px-4 py-2 transition bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-green-300">
                        <option value="" disabled
                            {{ old('document_type', session('document_type')) ? '' : 'selected' }}>
                            {{ __('Seleccione un tipo de documento') }}
                        </option>
                        @php
                            $documentTypes = [
                                'DNI' => 'DNI',
                                'PP' => 'Pasaporte',
                                'CC' => 'Cédula de Ciudadanía',
                                'CE' => 'Cédula de Extranjería',
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
                        {{ __('Número de Documento') }}
                    </label>
                    <input type="text" name="document_number" id="document_number" required
                        class="w-full px-4 py-2 transition bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-green-300"
                        placeholder="{{ __('Ingrese su Número de Documento') }}"
                        value="{{ old('document_number', session('document_number')) }}">
                </div>

                {{-- Código del evento --}}
                <div class="flex flex-col w-full gap-4 p-6">
                    <label for="event_code" class="text-lg font-semibold text-gray-700">
                        {{ __('Código del Evento') }}
                    </label>
                    <input type="text" id="event_code" name="event_code" required
                        class="w-full px-4 py-2 transition bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-green-300"
                        placeholder="{{ __('Ingrese el código del evento') }}"
                        value="{{ old('event_code', session('event_code')) }}">
                </div>
            </div>

            {{-- Mensaje de error si el evento no existe o el usuario no fue encontrado --}}
            @if (session('error'))
                <div class="w-full p-4 my-4 text-red-700 bg-red-100 border border-red-400">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Botón de búsqueda --}}
            <button type="submit"
                class="self-end px-4 py-2 mx-12 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl from-green-500 to-green-700 hover:scale-95">
                {{ __('Buscar Coincidencias') }}
            </button>
        </form>


        @if (session()->has('found') && !session('found'))
            <form action="{{ route('assistance.store', ['locale' => app()->getLocale()]) }}"
                class="flex flex-col gap-6 px-6 py-4 mx-4 bg-white rounded-md" method="POST">
                @csrf
                @method('POST')

                <div class="flex flex-col gap-3">
                    <h3 class="text-xl font-semibold text-gray-600">{{ __('Información Personal') }}</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col gap-2">
                            <label for="firstname" class="text-gray-500">{{ __('Nombre') }}</label>
                            <input type="text" id="firstname" name="firstname"
                                class="w-full px-4 py-2 transition bg-white border border-green-300 rounded-lg shadow-sm"
                                placeholder="{{ __('Ingrese su nombre') }}">
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="middlename" class="text-gray-500">{{ __('Segundo Nombre') }}</label>
                            <input type="text" id="middlename" name="middlename"
                                class="w-full px-4 py-2 transition bg-white border border-green-300 rounded-lg shadow-sm"
                                placeholder="{{ __('Ingrese su segundo nombre') }}">
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="lastname" class="text-gray-500">{{ __('Apellido') }}</label>
                            <input type="text" id="lastname" name="lastname"
                                class="w-full px-4 py-2 transition bg-white border border-green-300 rounded-lg shadow-sm"
                                placeholder="{{ __('Ingrese su apellido') }}">
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="second_lastname" class="text-gray-500">{{ __('Segundo Apellido') }}</label>
                            <input type="text" id="second_lastname" name="second_lastname"
                                class="w-full px-4 py-2 transition bg-white border border-green-300 rounded-lg shadow-sm"
                                placeholder="{{ __('Ingrese su segundo apellido') }}">
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-3">
                    <h3 class="text-xl font-semibold text-gray-600">{{ __('Contacto') }}</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col gap-2">
                            <label for="email" class="text-gray-500">{{ __('Correo Electrónico') }}</label>
                            <input type="email" id="email" name="email"
                                class="w-full px-4 py-2 transition bg-white border border-green-300 rounded-lg shadow-sm"
                                placeholder="{{ __('Ingrese su correo electrónico') }}">
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="institutional_email"
                                class="text-gray-500">{{ __('Correo Institucional') }}</label>
                            <input type="email" id="institutional_email" name="institutional_email"
                                class="w-full px-4 py-2 transition bg-white border border-green-300 rounded-lg shadow-sm"
                                placeholder="{{ __('Ingrese su correo institucional') }}">
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="phone" class="text-gray-500">{{ __('Teléfono') }}</label>
                            <input type="tel" id="phone" name="phone"
                                class="w-full px-4 py-2 transition bg-white border border-green-300 rounded-lg shadow-sm"
                                placeholder="{{ __('Ingrese su teléfono') }}">
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="address" class="text-gray-500">{{ __('Dirección') }}</label>
                            <input type="text" id="address" name="address"
                                class="w-full px-4 py-2 transition bg-white border border-green-300 rounded-lg shadow-sm"
                                placeholder="{{ __('Ingrese su dirección') }}">
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-3">
                    <h3 class="text-xl font-semibold text-gray-600">{{ __('Información Adicional') }}</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col gap-2">
                            <label for="university_id" class="text-gray-500">{{ __('Universidad') }}</label>
                            <input type="number" id="university_id" name="university_id"
                                class="w-full px-4 py-2 transition bg-white border border-green-300 rounded-lg shadow-sm"
                                placeholder="{{ __('Ingrese el ID de la universidad') }}">
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="genre" class="text-gray-500">{{ __('Género') }}</label>
                            <select id="genre" name="genre"
                                class="w-full px-4 py-2 transition bg-white border border-green-300 rounded-lg shadow-sm">
                                <option value="M">{{ __('Masculino') }}</option>
                                <option value="F">{{ __('Femenino') }}</option>
                                <option value="O">{{ __('Otro') }}</option>
                                <option value="PND">{{ __('Prefiero No Decirlo') }}</option>
                            </select>
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="birth_date" class="text-gray-500">{{ __('Fecha de Nacimiento') }}</label>
                            <input type="date" id="birth_date" name="birth_date"
                                class="w-full px-4 py-2 transition bg-white border border-green-300 rounded-lg shadow-sm">
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="minority" class="text-gray-500">{{ __('Pertenencia a Minoría') }}</label>
                            <select id="minority" name="minority"
                                class="w-full px-4 py-2 transition bg-white border border-green-300 rounded-lg shadow-sm">
                                <option value="">{{ __('Ninguna') }}</option>
                                <option value="afrodescendiente">{{ __('Afrodescendiente') }}</option>
                                <option value="indigena">{{ __('Indígena') }}</option>
                                <option value="gitano">{{ __('Gitano') }}</option>
                                <option value="LGTBISQ+">{{ __('LGTBISQ+') }}</option>
                                <option value="discapacitado">{{ __('Discapacitado') }}</option>
                                <option value="victima de conflicto armado">{{ __('Víctima de Conflicto Armado') }}
                                </option>
                                <option value="desplazado">{{ __('Desplazado') }}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        @endif

        @if (session()->has('error'))
            <div class="flex flex-col items-center justify-center w-full px-6 py-4 bg-white ">
                <h3 class="text-xl font-semibold text-red-600">{{ __('Error') }}</h3>
                <p class="text-gray-500">{{ session('error') }}</p>
            </div>
        @endif

    </div>
</x-app-layout>
