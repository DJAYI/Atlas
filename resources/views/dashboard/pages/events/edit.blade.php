<x-layouts.dashboard-layout>
    <div class="flex flex-row items-center justify-between my-4">
        <h2 class="text-2xl font-semibold text-primary-700">
            Gestión de Eventos | Editar Evento
        </h2>
    </div>

    <form action="{{ route('events.update', $event->id) }}" class="flex flex-col gap-6" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <x-validation-errors class="mb-4" :errors="$errors" />

        @php
            $readonly = !auth()->user()->can('edit events') ? 'readonly' : '';
            $disabled = !auth()->user()->can('edit events') ? 'disabled' : '';
        @endphp

        <div class="flex flex-col gap-3">
            <h3 class="text-xl font-semibold text-gray-600">Información General</h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col gap-2">
                    <label for="name" class="text-gray-500">Nombre</label>
                    <input required value="{{ $event->name }}" type="text" name="name" id="name"
                        placeholder="Ingrese el nombre del evento"
                        class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300"
                        {{ $readonly }}>
                    <small class="text-gray-400">Ingrese el nombre completo del evento</small>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="responsable" class="text-gray-500">Responsable</label>
                    <input required value="{{ $event->responsable }}" type="text" name="responsable" id="responsable"
                        placeholder="Ingrese el nombre del responsable"
                        class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300"
                        {{ $readonly }}>
                    <small class="text-gray-400">Indique quién será el responsable del evento</small>
                </div>
            </div>
        </div>
        <div class="flex flex-col gap-3">
            <h3 class="text-xl font-semibold text-gray-600">Fechas y Horarios</h3>
            <div class="grid grid-cols-4 gap-4">
                <div class="flex flex-col gap-2">
                    <label for="start_date" class="text-gray-500">Fecha de Inicio</label>
                    <input required type="date" name="start_date" id="start_date"
                        value="{{ old('start_date', $event->start_date ? $event->start_date->format('Y-m-d') : '') }}"
                        placeholder="Seleccione la fecha de inicio"
                        class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300"
                        {{ $readonly }}>
                    <small class="text-gray-400">Seleccione la fecha en la que comenzará el evento</small>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="end_date" class="text-gray-500">Fecha de Fin</label>
                    <input required type="date" name="end_date" id="end_date"
                        value="{{ old('end_date', $event->end_date ? $event->end_date->format('Y-m-d') : '') }}"
                        placeholder="Seleccione la fecha de fin"
                        class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300"
                        {{ $readonly }}>
                    <small class="text-gray-400">Seleccione la fecha en la que finalizará el evento</small>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="start_time" class="text-gray-500">Hora de Inicio</label>
                    <input required type="time" name="start_time" id="start_time"
                        value="{{ old('start_time', $event->start_time ? $event->start_time->format('H:i') : '') }}"
                        placeholder="Seleccione la hora de inicio"
                        class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300"
                        {{ $readonly }}>
                    <small class="text-gray-400">Indique la hora en la que comenzará el evento</small>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="end_time" class="text-gray-500">Hora de Fin</label>
                    <input required type="time" name="end_time" id="end_time"
                        value="{{ old('end_time', $event->end_time ? $event->end_time->format('H:i') : '') }}"
                        placeholder="Seleccione la hora de fin"
                        class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300"
                        {{ $readonly }}>
                    <small class="text-gray-400">Indique la hora en la que finalizará el evento</small>
                </div>
            </div>
        </div>
        <div class="flex flex-col gap-3">
            <h3 class="text-xl font-semibold text-gray-600">Información de Movilidad</h3>
            <div class="grid grid-cols-3 gap-4">
                <div class="flex flex-col gap-2">
                    <label for="modality" class="text-gray-500">Modalidad del Evento</label>
                    <select required name="modality" id="modality"
                        class="px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300"
                        {{ $disabled }}>
                        <option disabled value="">Seleccione una modalidad</option>
                        <option value="presencial" @if ($event->modality == App\Enums\EventModalityEnum::presencial) selected @endif>Presencial
                        </option>
                        <option value="virtual" @if ($event->modality == App\Enums\EventModalityEnum::virtual) selected @endif>Virtual</option>
                    </select>
                </div>

                <div class="flex-col {{ $event->modality === App\Enums\EventModalityEnum::virtual ? '' : 'hidden' }} gap-2"
                    id="at_home">
                    <label for="internationalization_at_home" class="text-gray-500">Internacionalización en
                        Casa</label>
                    <select name="internationalization_at_home" id="internationalization_at_home"
                        class="px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300"
                        {{ $disabled }}>
                        <option disabled value="">Seleccione una opción</option>
                        <option value="si" @if ($event->internationalization_at_home === App\Enums\EventInternalizationAtHomeEnum::si) selected @endif>Si</option>
                        <option value="no" @if ($event->internationalization_at_home === App\Enums\EventInternalizationAtHomeEnum::no) selected @endif>No</option>
                    </select>
                </div>

                <div class="flex flex-col gap-2">
                    <label for="location" class="text-gray-500">Localización del Evento</label>
                    <select required name="location" id="location"
                        class="px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300"
                        {{ $disabled }}>
                        <option disabled value="">Seleccione una localización</option>
                        <option value="nacional" @if ($event->location == App\Enums\EventLocationEnum::nacional) selected @endif>Nacional</option>
                        <option value="internacional" @if ($event->location == App\Enums\EventLocationEnum::internacional) selected @endif>Internacional
                        </option>
                        <option value="local" @if ($event->location == App\Enums\EventLocationEnum::local) selected @endif>Local</option>
                    </select>
                </div>

                <div class="flex flex-col gap-2 max-w-72">
                    <label for="university" class="text-gray-500">Universidad/es del Evento</label>
                    <select required id="university" class="w-full" name="universities[]" multiple
                        {{ $disabled }}>
                        <option disabled>Seleccione una universidad</option>
                        @foreach ($universities as $university)
                            <option value="{{ $university->id }}" @if (isset($event->universities) && in_array($university->id, $event->universities->pluck('id')->toArray())) selected @endif>
                                {{ $university->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="flex flex-col gap-3">
            <h3 class="text-xl font-semibold text-gray-600">Información Adicional</h3>
            <div class="grid grid-cols-3 gap-4">
                <div class="flex flex-col gap-2">
                    <label for="agreement" class="text-gray-500">¿Tiene Convenio?</label>
                    <select name="has_agreement" required id="has_agreement"
                        class="px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300"
                        {{ $disabled }}>
                        <option disabled value="">Seleccione una opción</option>
                        <option value="si" @if ($event->has_agreement == App\Enums\EventHasAgreementEnum::si) selected @endif>Si</option>
                        <option value="no" @if ($event->has_agreement == App\Enums\EventHasAgreementEnum::no) selected @endif>No</option>
                    </select>
                </div>

                <div
                    class="flex-col {{ $event->has_agreement === App\Enums\EventHasAgreementEnum::si ? '' : 'hidden' }} gap-2">
                    <label for="agreement_id" class="text-gray-500">Convenio</label>
                    <select name="agreement_id" id="agreement_id"
                        class="px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300"
                        {{ $disabled }}>
                        <option disabled value="">Seleccione un convenio</option>
                        @foreach ($agreements as $agreement)
                            <option value="{{ $agreement->id }}" @if ($event->agreement_id == $agreement->id) selected @endif>
                                {{ $agreement->code }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col gap-2">
                    <label for="activity_id" class="text-gray-500">Actividad</label>
                    <select name="activity_id" id="activity_id"
                        class="px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300"
                        {{ $disabled }}>
                        <option disabled value="">Seleccione una Actividad</option>
                        @foreach ($activities as $activity)
                            <option value="{{ $activity->id }}" @if ($event->activity_id == $activity->id) selected @endif>
                                {{ $activity->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col gap-2">
                    <label for="career_id" class="text-gray-500">Carrera</label>

                    <select name="career_id" id="career_id" required
                        class="px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300"
                        {{ $disabled }}>
                        <option selected disabled value="">Seleccione una carrera</option>
                        @foreach ($careers as $career)
                            <option value="{{ $career->id }}" @if ($event->career_id == $career->id) selected @endif>
                                {{ $career->name }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-gray-400">Seleccione la carrera asociada al evento</small>
                </div>

                <div class="flex flex-col col-span-3 gap-2">
                    <label for="description" class="text-gray-500">Descripción del Evento</label>
                    <textarea name="description" id="description" rows="4" maxlength="1000"
                        class="px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300"
                        placeholder="Escriba el nombre del invitado, la universidad a la que pertenece, su última formación académica y un breve perfil profesional. Indique también el tema a tratar y qué se busca fomentar en los asistentes (estudiantes, docentes, egresados, entre otros)."
                        {{ $readonly }}>{{ $event->description }}</textarea>
                    <small class="text-gray-400">Máximo 150 palabras. Sea conciso y claro en su descripción.</small>
                </div>

                <div class="flex flex-col col-span-3 gap-2">
                    <label for="significant_results" class="text-gray-500">Resultados Significativos</label>
                    <textarea name="significant_results" id="significant_results" rows="4" maxlength="1000"
                        class="px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300"
                        placeholder="Describa los resultados más significativos obtenidos del evento, logros alcanzados, impacto en los asistentes y cualquier otro resultado relevante."
                        {{ $readonly }}>{{ $event->significant_results }}</textarea>
                    <small class="text-gray-400">Máximo 150 palabras. Describa los principales logros y resultados del
                        evento.</small>
                </div>

                <div class="flex flex-col col-span-3 gap-2">
                    <div class="flex items-center justify-between">
                        <label for="photographic_support" class="text-gray-500">Soporte Fotográfico</label>
                        @if ($event->photographic_support && count($event->photographic_support) > 0)
                            <a href="{{ route('events.downloadPhotographicSupport', $event->id) }}"
                                class="inline-flex items-center px-3 py-1 text-xs font-medium text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                Descargar Todo (ZIP)
                            </a>
                        @endif
                    </div>

                    @if (!$readonly)
                        <div class="relative">
                            <input type="file" name="photographic_support[]" id="photographic_support"
                                class="px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100"
                                accept=".png,.jpg,.jpeg,.webp,.pdf" onchange="previewFiles(this)">
                            <small class="text-gray-400">Formatos permitidos: PNG, JPG, JPEG, WEBP, PDF. Máximo 2MB
                                por archivo.</small>
                        </div>

                        <!-- Vista previa de archivos nuevos -->
                        <div id="new-files-preview" class="hidden mt-3">
                            <h4 class="mb-2 text-sm font-medium text-gray-700">Archivos seleccionados para subir:</h4>
                            <div id="new-files-grid" class="grid grid-cols-2 gap-3 md:grid-cols-3 lg:grid-cols-4">
                            </div>
                        </div>
                    @endif

                    <!-- Archivos existentes -->
                    @if ($event->photographic_support && count($event->photographic_support) > 0)
                        <div class="mt-3">
                            <h4 class="mb-2 text-sm font-medium text-gray-700">
                                Archivos actuales ({{ count($event->photographic_support) }}):
                            </h4>
                            <div class="grid grid-cols-2 gap-3 md:grid-cols-3 lg:grid-cols-4">
                                @foreach ($event->getPhotographicSupportUrls() as $index => $file)
                                    <div
                                        class="relative overflow-hidden transition-shadow bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md">
                                        <!-- Vista previa del archivo -->
                                        <div class="flex items-center justify-center aspect-square bg-gray-50">
                                            @php
                                                $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                                                $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'webp']);
                                            @endphp

                                            @if ($isImage)
                                                <img src="{{ $file['url'] }}" alt="{{ $file['name'] }}"
                                                    class="object-cover w-full h-full cursor-pointer"
                                                    onclick="openImageModal('{{ $file['url'] }}', '{{ $file['name'] }}')">
                                            @else
                                                <div class="p-4 text-center">
                                                    <svg class="w-12 h-12 mx-auto mb-2 text-red-500" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                    <p class="text-xs font-medium text-gray-600">PDF</p>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Información del archivo -->
                                        <div class="p-3">
                                            <p class="mb-2 text-xs font-medium text-gray-900 truncate"
                                                title="{{ $file['name'] }}">
                                                {{ $file['name'] }}
                                            </p>

                                            <!-- Acciones -->
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-2">
                                                    <a href="{{ $file['url'] }}" target="_blank"
                                                        class="inline-flex items-center px-2 py-1 text-xs text-blue-600 transition-colors rounded hover:text-blue-800 hover:bg-blue-50">
                                                        <svg class="w-3 h-3 mr-1" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                                                            </path>
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                            </path>
                                                        </svg>
                                                        Ver
                                                    </a>
                                                    <a href="{{ $file['url'] }}" download
                                                        class="inline-flex items-center px-2 py-1 text-xs text-green-600 transition-colors rounded hover:text-green-800 hover:bg-green-50">
                                                        <svg class="w-3 h-3 mr-1" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                            </path>
                                                        </svg>
                                                        Descargar
                                                    </a>
                                                </div>

                                                @can('edit events')
                                                    <button type="button"
                                                        onclick="deletePhotographicSupportFile({{ $event->id }}, {{ $index }})"
                                                        class="inline-flex items-center p-1 text-red-600 transition-colors rounded hover:text-red-800 hover:bg-red-100">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                            </path>
                                                        </svg>
                                                    </button>
                                                @endcan
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        @if ($readonly)
                            <div class="py-8 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <p class="text-sm">No hay archivos de soporte fotográfico</p>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
            <div class="grid grid-cols-1">
                <div class="flex flex-row items-center justify-end gap-2">
                    @can('edit events')
                        <button type="submit"
                            class="inline-block px-4 py-2 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-primary-700 from-primary-500 hover:scale-95">
                            Actualizar Evento
                        </button>
                    @endcan
                    <a href="{{ route('events') }}" type="button" popovertarget="create-event"
                        class="px-4 py-2 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-red-700 from-red-500 hover:scale-95">
                        Cancelar
                    </a>
                </div>
            </div>
        </div>
    </form>
    <hr class="my-8 border-gray-300">
    <div class="flex flex-row justify-between mt-8">
        <div class="flex flex-row items-center gap-5">
            <h3 class="text-lg font-semibold">Todos los asistentes

                <span class="px-2 py-1 text-sm font-semibold text-white rounded-full bg-primary-500">
                    {{ $assistances->count() }}
                </span>
            </h3>

            <div class="flex flex-row items-center gap-3">
                @can('edit events')
                    {{-- Botón para enviar encuestas a todos --}}
                    <button type="button"
                        class="px-4 py-2 text-xs font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-primary-700 from-primary-500 hover:scale-95"
                        onclick="openSurveyPopover(null)" popovertarget="survey-popover">
                        Enviar Encuestas a Todos
                    </button>
                @endcan

                @can('generate reports')
                    {{-- Botón para descargar Plantilla de certificado --}}
                    <form class="inline-block" action="{{ route('generate.certificate') }}" method="POST">
                        @csrf
                        @method('POST')

                        <input type="hidden" name="event_id" value="{{ $event->id }}">
                        <button type="submit"
                            class="px-4 py-2 text-xs font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-secondary-700 from-secondary-500 hover:scale-95">
                            Plantilla de Certificado
                        </button>
                    </form>

                    <form class="inline-block" action="{{ route('events.exportAssistances', $event->id) }}"
                        method="POST">
                        @csrf
                        @method('POST')

                        <button type="submit"
                            class="px-4 py-2 text-xs font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-green-700 from-green-500 hover:scale-95">
                            Exportar Asistencias
                        </button>
                    </form>
                @endcan

                <form class="inline-block" action="{{ route('events.zipIdentityDocuments', $event->id) }}"
                    method="POST">
                    @csrf
                    @method('POST')

                    <button type="submit"
                        class="px-4 py-2 text-xs font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-blue-700 from-blue-500 hover:scale-95">
                        Exportar Documentos de Identidad
                    </button>
                </form>
            </div>



        </div>

        <div class="relative">

            <input required type="text" placeholder="Buscar asistente" id="filter-search"
                class="w-full px-4 py-2 pl-10 pr-4 placeholder-gray-500 transition bg-white border rounded-lg shadow-sm border-primary-300">
            <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
    </div>
    <br>
    <table class="w-full text-sm text-left text-gray-500 rtl:text-right ">
        <thead class="text-gray-700 uppercase ">
            <tr>
                <th scope="col" class="px-6 py-3">Nombre Completo</th>
                <th scope="col" class="px-6 py-3">Típo de Documento</th>
                <th scope="col" class="px-6 py-3">Num. de Documento</th>
                <th scope="col" class="px-6 py-3">Tipo</th>
                <th scope="col" class="px-6 py-3">Universidad</th>
                <th scope="col" class="px-6 py-3">Acciones</th>
            </tr>
        </thead>
        <tbody id="table-data">
            @foreach ($assistancesPaginated as $assistance)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td colspan="1" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        {{ $assistance->person->firstname }} {{ $assistance->person->lastname }}
                    </td>
                    <td colspan="1" class="px-6 py-4">
                        {{ $assistance->person->document_type }}
                    </td>
                    <td colspan="1" class="px-6 py-4">
                        {{ $assistance->person->document_number }}
                    </td>
                    <td colspan="1" class="px-6 py-4">
                        {{ $assistance->person->type }}
                    </td>
                    <td colspan="1" class="px-6 py-4">
                        {{ $assistance->person->university->name }}
                    </td>

                    {{-- Botón para enviar encuesta individual --}}
                    <td colspan="1" class="px-6 py-4">
                        <button type="button"
                            class="px-4 py-2 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-primary-700 from-primary-500 hover:scale-95"
                            onclick="openSurveyPopover({{ $assistance->id }})" popovertarget="survey-popover">
                            Enviar Encuesta
                        </button>
                    </td>
                </tr>
            @endforeach

            @if ($assistancesPaginated->isEmpty())
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        No hay asistentes registrados
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
    <div class="mt-4">
        {{ $assistancesPaginated->links() }}
    </div>

    <x-modals.send-survey-event-url id="send-individual-survey-modal" />

    <!-- Modal para vista previa de imágenes -->
    <div id="image-modal" class="fixed inset-0 z-50 items-center justify-center hidden p-4 bg-black bg-opacity-75">
        <div class="relative max-w-4xl max-h-full">
            <button onclick="closeImageModal()" class="absolute z-10 text-white top-4 right-4 hover:text-gray-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
            <img id="modal-image" src="" alt="" class="object-contain max-w-full max-h-full">
            <p id="modal-image-name" class="mt-2 text-center text-white"></p>
        </div>
    </div>
</x-layouts.dashboard-layout>

<script src="{{ asset('js/modules/utils/conditionalSelect.js') }}"></script>
<script src="{{ asset('js/modules/utils/multiSelectUtil.js') }}"></script>
<script src="{{ asset('js/modules/utils/dateValidation.js') }}"></script>
<script>
    let currentAssistanceId = null;

    function openSurveyPopover(assistanceId) {
        currentAssistanceId = assistanceId;
        document.getElementById('survey_url').value = '';
        const title = document.getElementById('survey-popover-title');
        title.textContent = assistanceId ?
            'Enviar encuesta individual' :
            'Enviar encuesta a todos los participantes';
    }

    function sendSurvey() {
        const url = document.getElementById('survey_url').value;
        if (!url) {
            alert('Debes ingresar una URL.');
            return;
        }

        let fetchUrl = '';
        const body = {
            url
        };

        if (currentAssistanceId) {
            fetchUrl = `{{ route('events.sendSurvey', ['event_id' => $event->id, 'assistance_id' => '__ID__']) }}`
                .replace('__ID__', currentAssistanceId);
        } else {
            fetchUrl = `{{ route('events.sendAllSurveys', $event->id) }}`;
        }

        fetch(fetchUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify(body)
        }).then(response => {
            if (response.ok) {
                if (typeof toast !== 'undefined') {
                    toast.success('Encuesta enviada exitosamente');
                } else {
                    alert('Encuesta enviada exitosamente');
                }
                location.reload();
            } else {
                if (typeof toast !== 'undefined') {
                    toast.error('Error al enviar la encuesta');
                } else {
                    alert('Error al enviar la encuesta');
                }
            }
        });

        document.getElementById('survey-popover').hidePopover();
        currentAssistanceId = null;
    }

    // Funciones para vista previa de archivos
    function previewFiles(input) {
        const files = Array.from(input.files);
        const previewContainer = document.getElementById('new-files-preview');
        const gridContainer = document.getElementById('new-files-grid');

        if (files.length === 0) {
            previewContainer.classList.add('hidden');
            return;
        }

        // Limpiar vista previa anterior
        gridContainer.innerHTML = '';
        previewContainer.classList.remove('hidden');

        files.forEach((file, index) => {
            const fileDiv = createFilePreview(file, index, true);
            gridContainer.appendChild(fileDiv);
        });
    }

    function createFilePreview(file, index, isNew = false) {
        const div = document.createElement('div');
        div.className = 'relative border border-gray-200 rounded-lg overflow-hidden bg-white shadow-sm';

        const isImage = file.type?.startsWith('image/') || /\.(jpg|jpeg|png|webp)$/i.test(file.name);
        const fileSize = file.size ? formatFileSize(file.size) : '';

        let previewContent = '';

        if (isImage && file.size) {
            // Crear vista previa para imágenes nuevas
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = div.querySelector('.file-preview-image');
                if (img) {
                    img.src = e.target.result;
                    img.onclick = () => openImageModal(e.target.result, file.name);
                }
            };
            reader.readAsDataURL(file);

            previewContent = `
                <div class="flex items-center justify-center aspect-square bg-gray-50">
                    <img class="object-cover w-full h-full cursor-pointer file-preview-image" src="" alt="${file.name}">
                </div>
            `;
        } else {
            // Vista previa para PDFs y otros archivos
            previewContent = `
                <div class="flex items-center justify-center aspect-square bg-gray-50">
                    <div class="p-4 text-center">
                        <svg class="w-12 h-12 mx-auto mb-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        <p class="text-xs font-medium text-gray-600">${file.name.split('.').pop().toUpperCase()}</p>
                    </div>
                </div>
            `;
        }

        div.innerHTML = `
            ${previewContent}
            <div class="p-3">
                <p class="mb-1 text-xs font-medium text-gray-900 truncate" title="${file.name}">
                    ${file.name}
                </p>
                ${fileSize ? `<p class="mb-2 text-xs text-gray-500">${fileSize}</p>` : ''}
                <div class="flex items-center justify-between">
                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full">
                        Nuevo
                    </span>
                    ${isNew ? `
                        <button type="button" onclick="removeFileFromPreview(${index})" 
                                class="inline-flex items-center p-1 text-red-600 transition-colors rounded hover:text-red-800 hover:bg-red-100">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    ` : ''}
                </div>
            </div>
        `;

        return div;
    }

    function removeFileFromPreview(index) {
        const input = document.getElementById('photographic_support');
        const dt = new DataTransfer();

        Array.from(input.files).forEach((file, i) => {
            if (i !== index) {
                dt.items.add(file);
            }
        });

        input.files = dt.files;
        previewFiles(input);
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // Funciones para modal de imágenes
    function openImageModal(src, name) {
        const modal = document.getElementById('image-modal');
        const modalImage = document.getElementById('modal-image');
        const modalImageName = document.getElementById('modal-image-name');

        modalImage.src = src;
        modalImageName.textContent = name;
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        // Evitar scroll del body
        document.body.style.overflow = 'hidden';
    }

    function closeImageModal() {
        const modal = document.getElementById('image-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');

        // Restaurar scroll del body
        document.body.style.overflow = 'auto';
    }

    // Cerrar modal con Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeImageModal();
        }
    });

    // Cerrar modal al hacer clic fuera de la imagen
    document.getElementById('image-modal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeImageModal();
        }
    });

    // Función para eliminar archivo fotográfico
    function deletePhotographicSupportFile(eventId, fileIndex) {
        if (!confirm('¿Estás seguro de que quieres eliminar este archivo?')) {
            return;
        }

        const form = document.createElement('form');
        form.method = 'POST';
        form.action =
            '{{ route('events.removePhotographicSupportFile', ['eventId' => ':eventId', 'fileIndex' => ':fileIndex']) }}'
            .replace(':eventId', eventId)
            .replace(':fileIndex', fileIndex);
        form.style.display = 'none';

        // Agregar token CSRF
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
            document.querySelector('input[name="_token"]')?.value;

        if (csrfToken) {
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken;
            form.appendChild(csrfInput);
        }

        // Agregar método DELETE
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);

        document.body.appendChild(form);
        form.submit();
    }
</script>
