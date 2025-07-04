<x-app-layout>
    <x-utils.language-selector route="assistance" />

    <div style="view-transition-name: assistance-view"
        class="grid mt-2 w-auto min-h-screen grid-cols-1 grid-rows-[100px_1fr] gap-5 mx-auto bg-white sm:max-w-5xl rounded-t-xl md:grid-cols-1 ">

        <x-utils.assistance-header-verifying />

        @if (session()->has('found'))

            <form id="assistance-form" action="{{ route('assistance.store', ['locale' => app()->getLocale()]) }}"
                class="flex flex-col gap-6 px-6 py-4 mx-4 bg-white rounded-md" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('POST')

                {{-- Form Header --}}
                <h2 class="text-3xl font-semibold">
                    {{ __('Registro de Asistencia') }}
                </h2>

                <div class="flex flex-col gap-3">
                    <h3 class="text-xl font-semibold text-gray-600">{{ __('Información Personal') }}</h3>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                        <div class="flex flex-col gap-2">
                            <label for="first_name" class="text-gray-500">{{ __('Nombre') }}<span
                                    class="text-secondary-400">*</span></label>
                            <input type="text" id="first_name" name="first_name"
                                class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300"
                                placeholder="{{ __('Ingrese su nombre') }}"
                                value="{{ session('found') ? session('person')->firstname : '' }}">
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="middle_name" class="text-gray-500">{{ __('Segundo Nombre') }}</label>
                            <input type="text" id="middle_name" name="middle_name"
                                class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300"
                                placeholder="{{ __('Ingrese su segundo nombre') }}"
                                value="{{ session('found') ? session('person')->middlename : '' }}">
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="last_name" class="text-gray-500">{{ __('Apellido') }}<span
                                    class="text-secondary-400">*</span></label>
                            <input type="text" id="last_name" name="last_name"
                                class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300"
                                placeholder="{{ __('Ingrese su apellido') }}"
                                value="{{ session('found') ? session('person')->lastname : '' }}">
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="second_last_name" class="text-gray-500">{{ __('Segundo Apellido') }}</label>
                            <input type="text" id="second_last_name" name="second_last_name"
                                class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300"
                                placeholder="{{ __('Ingrese su segundo apellido') }}"
                                value="{{ session('found') ? session('person')->second_lastname : '' }}">
                        </div>



                    </div>
                </div>

                <div class="flex flex-col gap-3">
                    <h3 class="text-xl font-semibold text-gray-600">{{ __('Contacto') }}</h3>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div class="flex flex-col gap-2">
                            <label for="personal_email" class="text-gray-500">{{ __('Correo Electrónico') }}<span
                                    class="text-secondary-400">*</span></label>
                            <input type="email" id="personal_email" name="personal_email"
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
                            <label for="phone_number" class="text-gray-500">{{ __('Teléfono') }}</label>
                            <input type="tel" id="phone_number" name="phone_number"
                                class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300"
                                placeholder="{{ __('Ingrese su teléfono') }}"
                                value="{{ session('found') ? session('person')->phone : '' }}">
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="country_of_origin" class="text-gray-500">{{ __('País de Origen') }}<span
                                    class="text-secondary-400">*</span></label>
                            <select id="country_of_origin" name="country_of_origin"
                                class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300">
                                <option value="" disabled
                                    {{ old('country_of_origin', session('country_id')) ? '' : 'selected' }}>
                                    {{ __('Seleccione un país') }}
                                </option>
                                @foreach ($countries->sortBy('name') as $country)
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
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div class="flex flex-col gap-2">
                            <label for="origin_university" class="text-gray-500">{{ __('Universidad de Origen') }}<span
                                    class="text-secondary-400">*</span></label>
                            <select id="origin_university" name="origin_university"
                                class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300">
                                <option value="" disabled selected>{{ __('Seleccione una universidad') }}
                                </option>
                                @foreach ($universities->sortBy('name') as $university)
                                    <option value="{{ $university->id }}"
                                        {{ session('found') && session('person')->university_id == $university->id ? 'selected' : '' }}>
                                        {{ $university->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="academic_program" class="text-gray-500">{{ __('Programa') }}<span
                                    class="text-secondary-400">*</span></label>
                            <select id="academic_program" name="academic_program"
                                class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300">
                                <option value="" disabled selected>{{ __('Seleccione un Programa') }}
                                </option>
                                @foreach ($careers->sortBy('name') as $career)
                                    <option value="{{ $career->id }}"
                                        {{ session('found') && session('person')->career_id == $career->id ? 'selected' : '' }}>
                                        {{ $career->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex flex-col gap-2">
                            <label for="biological_sex" class="text-gray-500">{{ __('Sexo Biológico') }}<span
                                    class="text-secondary-400">*</span></label>
                            <select id="biological_sex" name="biological_sex"
                                class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300">
                                <option value="" disabled
                                    {{ old('biological_sex', session('genre')) ? '' : 'selected' }}>
                                    {{ __('Seleccione una opción') }}
                                </option>
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
                            <label for="minority_group" class="text-gray-500">{{ __('Pertenencia a Minoría') }}<span
                                    class="text-secondary-400">*</span></label>
                            <select id="minority_group" name="minority_group"
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
                                <option value="PDET"
                                    {{ session('found') && session('person')->minority == 'PDET' ? 'selected' : '' }}>
                                    {{ __('Población PDET') }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-3">
                    <h3 class="text-xl font-semibold text-gray-600">{{ __('Información de Asistencia') }}</h3>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div class="col-span-2">
                            @livewire('select-mobility', ['type' => session('found') ? session('person')->type : ''])

                        </div>
                        <div class="flex flex-col col-span-2 gap-2 md:col-span-1">
                            <label for="destination_university"
                                class="text-gray-500">{{ __('Universidad de Destino') }}<span
                                    class="text-secondary-400">*</span></label>
                            <select id="destination_university" name="destination_university"
                                class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300">
                                <option value="" disabled selected>{{ __('Seleccione una universidad') }}
                                </option>

                                @if (session('event') && isset(session('event')->universities))
                                    <p>{{ session('event')->universities->count() }}
                                        {{ __('available_universities') }}</p>

                                    @foreach (session('event')->universities->sortBy('name') as $university)
                                        <option value="{{ $university->id }}">
                                            {{ $university->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="flex-col hidden col-span-2 gap-2 md:col-span-1">
                            <label for="identity_document"
                                class="text-gray-500">{{ __('Fotocopia de Documento de Identidad') }}<span
                                    class="text-secondary-400">*</span></label>
                            <input type="file" id="identity_document"
                                value="{{ old('identity_document', session('identity_document_file')) }}"
                                name="identity_document"
                                class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300"
                                accept="image/jpeg, image/png, image/jpg, image/webp,application/pdf"
                                @if (!session('identity_document_file')) required @endif>
                            <p class="text-sm text-gray-500">
                                {{ __('Formato permitido: JPG, JPEG, PNG, WEBP, PDF. Tamaño máximo: 2MB.') }}
                            </p>

                            <div id="preview" class="flex flex-col items-center justify-center w-full mt-2">
                                <img id="preview-image" onload="this.style.opacity='1'"
                                    src="{{ asset('storage/' . session('identity_document_file')) }}"
                                    class="object-cover opacity-0 transition {{ session('identity_document_file') ? '' : 'hidden' }} w-full h-full rounded-lg shadow-sm border-primary-300"
                                    alt="{{ __('Vista previa del documento de identidad') }}">
                            </div>
                            @if ($errors->has('identity_document'))
                                <p class="mt-2 text-sm text-red-500">
                                    {{ $errors->first('identity_document') }}
                                </p>
                            @endif
                        </div>
                        {{-- Submit Button --}}

                        <div
                            class="flex flex-col justify-between w-full col-span-2 gap-4 px-6 py-4 mt-4 bg-white rounded-lg md:col-span-2 md:flex-row">
                            <div class="grid w-full grid-cols-1 gap-4 md:grid-cols-2">
                                <button type="submit"
                                    class="px-4 w-full ms-4 col-span-1 items-center mx-auto mt-4 py-3 text-lg font-semibold text-white transition bg-secondary-500 rounded-md hover:shadow-[1px_1px_20px] bg-gradient-to-tr to-secondary-500 from-primary-500 hover:shadow-primary-400/60 bg-blend-lighten hover:bg-secondary-400">{{ __('Registrar Asistencia') }}</button>
                            </div>
                            <div class="cf-turnstile" data-sitekey={{ config('services.turnstile.site_key') }}
                                data-response-field-name="cf-turnstile-response">
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        @endif

        <div class="flex flex-col items-center justify-center w-full px-6 py-4 bg-white ">
            <img src="{{ asset('images/logo_tecno_comfenalco.png') }}" class="h-24" alt="">
            <p class="text-gray-500">2025 &copy; Copyright - Fundación Universitaria Tecnológico Comfenalco</p>
        </div>

    </div>
</x-app-layout>

<script src="{{ asset('js/modules/utils/countryOriginValidation.js') }}"></script>
<script src="{{ asset('js/modules/utils/loadPreviewDocumentFile.js') }}"></script>
