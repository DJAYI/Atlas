<x-app-layout>
    <x-utils.language-selector route="assistance" />

    <div
        class="grid w-auto min-h-screen grid-cols-1 grid-rows-[100px_1fr] gap-5 mx-auto bg-white sm:max-w-5xl rounded-t-xl md:grid-cols-1 ">

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

        <form action="" class="flex flex-col items-center" method="GET">
            @csrf
            @method('GET')

            <div class="flex flex-row items-center justify-center w-full gap-4 p-6">
                <div class="flex flex-col w-full gap-4 p-6">
                    <label for="document_type"
                        class="text-lg font-semibold text-gray-700">{{ __('Tipo de documento') }}</label>
                    <select name="document_type" id="document_type" required
                        class="w-full px-4 py-2 placeholder-gray-500 transition bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-green-300">
                        <option value="" disabled selected>{{ __('Seleccione un tipo de documento') }}</option>
                        <option value="DNI">{{ __('DNI') }}</option>
                        <option value="PP">{{ __('Pasaporte') }}</option>
                        <option value="CC">{{ __('Cédula de Ciudadanía') }}</option>
                        <option value="CE">{{ __('Cedula de Extranjería') }}</option>
                        <option value="TI">{{ __('Tarjeta de Identidad') }}</option>
                        <option value="CA">{{ __('Carnet de Extranjería') }}</option>
                        <option value="Otro">{{ __('Otro') }}</option>
                    </select>
                </div>

                <div class="flex flex-col w-full gap-4 p-6">
                    <label for="document_number"
                        class="text-lg font-semibold text-gray-700">{{ __('Número de Documento') }}</label>
                    <input type="text" name="document_number" id="document_number" required
                        class="w-full px-4 py-2 placeholder-gray-500 transition bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-green-300"
                        placeholder="{{ __('document_number') }}">
                </div>
            </div>
            <button type="submit"
                class="self-end px-4 py-2 mx-12 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-green-700 from-green-500 hover:scale-95">
                {{ __('Buscar Asistente') }}
            </button>

        </form>

    </div>
</x-app-layout>
