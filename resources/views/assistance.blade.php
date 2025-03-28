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

        <form action="{{ route('assistance.verify') }}" class="flex flex-col items-center" method="POST">
            @csrf
            @method('POST')

            <div class="flex flex-row items-center justify-center w-full px-6">
                <div class="flex flex-col w-full gap-4 p-6">
                    <label for="document_type"
                        class="text-lg font-semibold text-gray-700">{{ __('Tipo de documento') }}</label>
                    <select name="document_type" id="document_type" required
                        class="w-full px-4 py-2 placeholder-gray-500 transition bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-green-300">
                        <option value="" disabled @if (empty($document_type)) selected @endif>
                            {{ __('Seleccione un tipo de documento') }}</option>

                        <option value="DNI" @if (isset($document_type) && $document_type == 'DNI') selected @endif>{{ __('DNI') }}
                        </option>

                        <option value="PP" @if (isset($document_type) && $document_type == 'PP') selected @endif>{{ __('Pasaporte') }}
                        </option>

                        <option value="CC" @if (isset($document_type) && $document_type == 'CC') selected @endif>
                            {{ __('Cédula de Ciudadanía') }}
                        </option>

                        <option value="CE" @if (isset($document_type) && $document_type == 'CE') selected @endif>
                            {{ __('Cedula de Extranjería') }}</option>

                        <option value="TI" @if (isset($document_type) && $document_type == 'TI') selected @endif>
                            {{ __('Tarjeta de Identidad') }}</option>

                        <option value="CA" @if (isset($document_type) && $document_type == 'CA') selected @endif>
                            {{ __('Certificado Cabildo') }}</option>

                        <option value="Otro" @if (isset($document_type) && $document_type == 'Otro') selected @endif>{{ __('Otro') }}
                        </option>
                    </select>
                </div>

                <div class="flex flex-col w-full gap-4 p-6">
                    <label for="document_number"
                        class="text-lg font-semibold text-gray-700">{{ __('Número de Documento') }}</label>
                    <input type="text" name="document_number" id="document_number" required
                        class="w-full px-4 py-2 placeholder-gray-500 transition bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-green-300"
                        placeholder="{{ __('Ingrese su Número de Documento') }}" value="{{ $document_number ?? '' }}">
                </div>

                <div class="flex flex-col w-full gap-4 p-6">


                    <label for="document_number"
                        class="text-lg font-semibold text-gray-700">{{ __('Código del Evento') }}</label>

                    <input type="text" id="event_code" name="event_code"
                        class="w-full px-4 py-2 placeholder-gray-500 transition bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-green-300">
                </div>
            </div>
            <button type="submit"
                class="self-end px-4 py-2 mx-12 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-green-700 from-green-500 hover:scale-95">
                {{ __('Buscar Coincidencias') }}
            </button>
        </form>

        @isset($found)
            @if (!$found)
                <form action="{{ route('assistance.store') }}"
                    class="px-6 py-4 mx-4 bg-white rounded-md flex flex-col gap-6" method="POST">
                    @csrf
                    @method('POST')

                    <div class="flex flex-col gap-3">
                        <h3 class="text-xl font-semibold text-gray-600">Información Personal</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="flex flex-col gap-2">
                                <label for="firstname" class="text-gray-500">Nombre</label>
                                <input type="text" id="firstname" name="firstname"
                                    class="w-full px-4 py-2 transition bg-white border border-green-300 rounded-lg shadow-sm">
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="middlename" class="text-gray-500">Segundo Nombre</label>
                                <input type="text" id="middlename" name="middlename"
                                    class="w-full px-4 py-2 transition bg-white border border-green-300 rounded-lg shadow-sm">
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="lastname" class="text-gray-500">Apellido</label>
                                <input type="text" id="lastname" name="lastname"
                                    class="w-full px-4 py-2 transition bg-white border border-green-300 rounded-lg shadow-sm">
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="second_lastname" class="text-gray-500">Segundo Apellido</label>
                                <input type="text" id="second_lastname" name="second_lastname"
                                    class="w-full px-4 py-2 transition bg-white border border-green-300 rounded-lg shadow-sm">
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3">
                        <h3 class="text-xl font-semibold text-gray-600">Contacto</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="flex flex-col gap-2">
                                <label for="email" class="text-gray-500">Correo Electrónico</label>
                                <input type="email" id="email" name="email"
                                    class="w-full px-4 py-2 transition bg-white border border-green-300 rounded-lg shadow-sm">
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="institutional_email" class="text-gray-500">Correo Institucional</label>
                                <input type="email" id="institutional_email" name="institutional_email"
                                    class="w-full px-4 py-2 transition bg-white border border-green-300 rounded-lg shadow-sm">
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="phone" class="text-gray-500">Teléfono</label>
                                <input type="tel" id="phone" name="phone"
                                    class="w-full px-4 py-2 transition bg-white border border-green-300 rounded-lg shadow-sm">
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="address" class="text-gray-500">Dirección</label>
                                <input type="text" id="address" name="address"
                                    class="w-full px-4 py-2 transition bg-white border border-green-300 rounded-lg shadow-sm">
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3">
                        <h3 class="text-xl font-semibold text-gray-600">Información Adicional</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="flex flex-col gap-2">
                                <label for="university_id" class="text-gray-500">Universidad</label>
                                <input type="number" id="university_id" name="university_id"
                                    class="w-full px-4 py-2 transition bg-white border border-green-300 rounded-lg shadow-sm">
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="genre" class="text-gray-500">Género</label>
                                <select id="genre" name="genre"
                                    class="w-full px-4 py-2 transition bg-white border border-green-300 rounded-lg shadow-sm">
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                    <option value="O">Otro</option>
                                    <option value="PND">Prefiero No Decirlo</option>
                                </select>
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="birth_date" class="text-gray-500">Fecha de Nacimiento</label>
                                <input type="date" id="birth_date" name="birth_date"
                                    class="w-full px-4 py-2 transition bg-white border border-green-300 rounded-lg shadow-sm">
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="minority" class="text-gray-500">Pertenencia a Minoría</label>
                                <select id="minority" name="minority"
                                    class="w-full px-4 py-2 transition bg-white border border-green-300 rounded-lg shadow-sm">
                                    <option value="">Ninguna</option>
                                    <option value="afrodescendiente">Afrodescendiente</option>
                                    <option value="indigena">Indígena</option>
                                    <option value="gitano">Gitano</option>
                                    <option value="LGTBISQ+">LGTBISQ+</option>
                                    <option value="discapacitado">Discapacitado</option>
                                    <option value="victima de conflicto armado">Víctima de Conflicto Armado</option>
                                    <option value="desplazado">Desplazado</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </form>
            @endif

            <form action="{{ route('assistance.store') }}" class="px-6 py-4 mx-4 bg-white rounded-md flex flex-col gap-6"
                method="POST">
                @csrf
                @method('POST')


            </form>
        @endisset

    </div>
</x-app-layout>
