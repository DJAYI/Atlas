<x-app-layout>
    <x-utils.language-selector route="assistance" />

    <div style="view-transition-name: assistance-view"
        class="grid mt-2 w-auto min-h-screen grid-cols-1 grid-rows-[100px_1fr] gap-5 mx-auto bg-white sm:max-w-5xl rounded-t-xl md:grid-cols-1 ">

        <x-utils.assistance-header-verifying />


        @if (session()->has('found') && !session('found'))

            <form action="{{ route('assistance.store', ['locale' => app()->getLocale()]) }}"
                class="flex flex-col gap-6 px-6 py-4 mx-4 bg-white rounded-md" method="POST">
                @csrf
                @method('POST')

                {{-- Encabezado de formulario --}}
                <h2 class="text-3xl font-semibold">
                    {{ __('Registro de Asistencia') }}
                </h2>

                <div class="flex flex-col gap-3">
                    <h3 class="text-xl font-semibold text-gray-600">{{ __('Información Personal') }}</h3>
                    <div class="grid grid-cols-2 gap-4">

                        <div class="flex flex-col gap-2">
                            <label for="firstname" class="text-gray-500">{{ __('Nombre') }}<span
                                    class="text-secondary-400">*</span></label>
                            <input type="text" id="firstname" name="firstname"
                                class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300"
                                placeholder="{{ __('Ingrese su nombre') }}"
                                value="{{ session('found') ? session('person')->firstname : '' }}">
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="middlename" class="text-gray-500">{{ __('Segundo Nombre') }}</label>
                            <input type="text" id="middlename" name="middlename"
                                class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300"
                                placeholder="{{ __('Ingrese su segundo nombre') }}"
                                value="{{ session('found') ? session('person')->middlename : '' }}">
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="lastname" class="text-gray-500">{{ __('Apellido') }}<span
                                    class="text-secondary-400">*</span></label>
                            <input type="text" id="lastname" name="lastname"
                                class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300"
                                placeholder="{{ __('Ingrese su apellido') }}"
                                value="{{ session('found') ? session('person')->lastname : '' }}">
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="second_lastname" class="text-gray-500">{{ __('Segundo Apellido') }}</label>
                            <input type="text" id="second_lastname" name="second_lastname"
                                class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300"
                                placeholder="{{ __('Ingrese su segundo apellido') }}"
                                value="{{ session('found') ? session('person')->second_lastname : '' }}">
                        </div>

                        <div class="col-span-2">
                            <livewire:select-mobility />
                        </div>

                    </div>
                </div>

                <div class="flex flex-col gap-3">
                    <h3 class="text-xl font-semibold text-gray-600">{{ __('Contacto') }}</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col gap-2">
                            <label for="email" class="text-gray-500">{{ __('Correo Electrónico') }}<span
                                    class="text-secondary-400">*</span></label>
                            <input type="email" id="email" name="email"
                                class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300"
                                placeholder="{{ __('Ingrese su correo electrónico') }}"
                                value="{{ session('found') ? session('person')->email : '' }}">
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="institutional_email"
                                class="text-gray-500">{{ __('Correo Institucional') }}</label>
                            <input type="email" id="institutional_email" name="institutional_email"
                                class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300"
                                placeholder="{{ __('Ingrese su correo institucional') }}"
                                value="{{ session('found') ? session('person')->institutional_email : '' }}">
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="phone" class="text-gray-500">{{ __('Teléfono') }}</label>
                            <input type="tel" id="phone" name="phone"
                                class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300"
                                placeholder="{{ __('Ingrese su teléfono') }}"
                                value="{{ session('found') ? session('person')->phone : '' }}">
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="country_id" class="text-gray-500">{{ __('País de Origen') }}<span
                                    class="text-secondary-400">*</span></label>
                            <select id="country_id" name="country_id"
                                class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300">
                                <option value="" disabled
                                    {{ old('country_id', session('country_id')) ? '' : 'selected' }}>
                                    {{ __('Seleccione un país') }}
                                </option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}"
                                        {{ session('found') && session('person')->country_id == $country->id ? 'selected' : '' }}>
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-3">
                    <h3 class="text-xl font-semibold text-gray-600">{{ __('Información Adicional') }}</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col gap-2">
                            <label for="university_id" class="text-gray-500">{{ __('Universidad de Origen') }}<span
                                    class="text-secondary-400">*</span></label>
                            <select id="university_id" name="university_id"
                                class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300">
                                <option value="" disabled selected>{{ __('Seleccione una universidad') }}
                                </option>
                                @foreach ($universities as $university)
                                    <option value="{{ $university->id }}"
                                        {{ session('found') && session('person')->university_id == $university->id ? 'selected' : '' }}>
                                        {{ $university->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="career_id" class="text-gray-500">{{ __('Programa') }}<span
                                    class="text-secondary-400">*</span></label>
                            <select id="career_id" name="career_id"
                                class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300">
                                <option value="" disabled selected>{{ __('Seleccione un Programa') }}
                                </option>
                                @foreach ($careers as $career)
                                    <option value="{{ $career->id }}"
                                        {{ session('found') && session('person')->career_id == $career->id ? 'selected' : '' }}>
                                        {{ $career->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>



                        <div class="flex flex-col gap-2">
                            <label for="genre" class="text-gray-500">{{ __('Género') }}<span
                                    class="text-secondary-400">*</span></label>
                            <select id="genre" name="genre"
                                class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300">
                                <option value="M"
                                    {{ session('found') && session('person')->genre == 'M' ? 'selected' : '' }}>
                                    {{ __('Masculino') }}</option>
                                <option value="F"
                                    {{ session('found') && session('person')->genre == 'F' ? 'selected' : '' }}>
                                    {{ __('Femenino') }}</option>
                                <option value="O"
                                    {{ session('found') && session('person')->genre == 'O' ? 'selected' : '' }}>
                                    {{ __('Otro') }}</option>
                                <option value="PND"
                                    {{ session('found') && session('person')->genre == 'PND' ? 'selected' : '' }}>
                                    {{ __('Prefiero No Decirlo') }}</option>
                            </select>
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="birth_date" class="text-gray-500">{{ __('Fecha de Nacimiento') }}<span
                                    class="text-secondary-400">*</span></label>
                            <input type="date" id="birth_date" name="birth_date"
                                class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300"
                                value="{{ old('birth_date', session('found') ? session('person')->birth_date->format('Y-m-d') : '') }}">
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="minority" class="text-gray-500">{{ __('Pertenencia a Minoría') }}<span
                                    class="text-secondary-400">*</span></label>
                            <select id="minority" name="minority"
                                class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300">
                                <option value=""
                                    {{ session('found') && !session('person')->minority ? 'selected' : '' }}>
                                    {{ __('Ninguna') }}</option>
                                <option value="afrodescendiente"
                                    {{ session('found') && session('person')->minority == 'afrodescendiente' ? 'selected' : '' }}>
                                    {{ __('Afrodescendiente') }}</option>
                                <option value="indigena"
                                    {{ session('found') && session('person')->minority == 'indigena' ? 'selected' : '' }}>
                                    {{ __('Indígena') }}</option>
                                <option value="gitano"
                                    {{ session('found') && session('person')->minority == 'gitano' ? 'selected' : '' }}>
                                    {{ __('Gitano') }}</option>
                                <option value="LGTBISQ+"
                                    {{ session('found') && session('person')->minority == 'LGTBISQ+' ? 'selected' : '' }}>
                                    {{ __('LGTBISQ+') }}</option>
                                <option value="discapacitado"
                                    {{ session('found') && session('person')->minority == 'discapacitado' ? 'selected' : '' }}>
                                    {{ __('Discapacitado') }}</option>
                                <option value="victima de conflicto armado"
                                    {{ session('found') && session('person')->minority == 'victima de conflicto armado' ? 'selected' : '' }}>
                                    {{ __('Víctima de Conflicto Armado') }}</option>
                                <option value="desplazado"
                                    {{ session('found') && session('person')->minority == 'desplazado' ? 'selected' : '' }}>
                                    {{ __('Desplazado') }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-3">
                    <h3 class="text-xl font-semibold text-gray-600">{{ __('Información de Asistencia') }}</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col gap-2">
                            <label for="university_id" class="text-gray-500">{{ __('Universidad de Destino') }}<span
                                    class="text-secondary-400">*</span></label>
                            <select id="university_id" name="university_id"
                                class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300">
                                <option value="" disabled selected>{{ __('Seleccione una universidad') }}
                                </option>
                                @foreach (session('event')->universities as $university)
                                    <option value="{{ $university->id }}">
                                        {{ $university->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex-col gap-2 hidden">
                            <label for="identity_document_file"
                                class="text-gray-500">{{ __('Fotocopia de Documento de Identidad') }}<span
                                    class="text-secondary-400">*</span></label>
                            <input type="file" id="identity_document_file" name="identity_document_file"
                                class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300"
                                accept="image/jpeg, image/png, image/jpg, image/webp">
                            <p class="text-sm text-gray-500">
                                {{ __('Formato permitido: JPG, JPEG, PNG, WEBP. Tamaño máximo: 2MB.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </form>
        @endif

        <div class="flex flex-col items-center justify-center w-full px-6 py-4 bg-white ">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQtxW4Gq4oqpJmqr-vrf2VR-Kjo_lTh7vFtDA&s"
                class="h-16" alt="">
            <p class="text-gray-500">2025 &copy; Copyright - Fundación Universitaria Tecnológico Comfenalco</p>
        </div>

    </div>
</x-app-layout>

@vite('resources/js/modules/utils/countryOriginValidation.js')
