<x-layouts.dashboard-layout>
    <div class="flex flex-row items-center justify-between my-4">
        <h2 class="text-2xl font-semibold text-green-700">
            Gestión de Eventos | Editar Evento
        </h2>
    </div>

    <form action="{{ route('events.update', $event->id) }}" class="flex flex-col gap-6" method="POST">
        @csrf
        @method('PUT')

        <div class="flex flex-col gap-3">
            <h3 class="text-xl font-semibold text-gray-600">Información General</h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col gap-2">
                    <label for="name" class="text-gray-500">Nombre</label>
                    <input required value="{{ $event->name }}" type="text" name="name" id="name"
                        class="py-2 px-4 w-[400px] bg-white border border-green-300 rounded-lg shadow-sm transition">
                </div>
                <div class="flex flex-col gap-2">
                    <label for="responsable" class="text-gray-500">Responsable</label>
                    <input required value="{{ $event->responsable }}" type="text" name="responsable" id="responsable"
                        class="py-2 px-4 w-[400px] bg-white border border-green-300 rounded-lg shadow-sm transition">
                </div>
            </div>
        </div>
        <div class="flex flex-col gap-3">
            <h3 class="text-xl font-semibold text-gray-600">Fechas y Horarios</h3>
            <div class="grid grid-cols-4 gap-4">
                <div class="flex flex-col gap-2">
                    <label for="start_date" class="text-gray-500">Fecha de Inicio</label>
                    <input required type="date" name="start_date" id="start_date" min="{{ date('Y-m-d') }}"
                        value="{{ old('start_date', $event->start_date ? $event->start_date->format('Y-m-d') : '') }}"
                        class="py-2 px-4 w-[200px] bg-white border border-green-300 rounded-lg shadow-sm transition">
                </div>
                <div class="flex flex-col gap-2">
                    <label for="end_date" class="text-gray-500">Fecha de Fin</label>
                    <input required type="date" name="end_date" id="end_date" min="{{ date('Y-m-d') }}"
                        value="{{ old('end_date', $event->end_date ? $event->end_date->format('Y-m-d') : '') }}"
                        class="py-2 px-4 w-[200px] bg-white border border-green-300 rounded-lg shadow-sm transition">
                </div>
                <div class="flex flex-col gap-2">
                    <label for="start_time" class="text-gray-500">Hora de Inicio</label>
                    <input required type="time" name="start_time" id="start_time"
                        value="{{ old('start_time', $event->start_time ? $event->start_time->format('H:i') : '') }}"
                        class="py-2 px-4 w-[200px] bg-white border border-green-300 rounded-lg shadow-sm transition">
                </div>
                <div class="flex flex-col gap-2">
                    <label for="end_time" class="text-gray-500">Hora de Fin</label>
                    <input required type="time" name="end_time" id="end_time"
                        value="{{ old('end_time', $event->end_time ? $event->end_time->format('H:i') : '') }}"
                        class="py-2 px-4 w-[200px] bg-white border border-green-300 rounded-lg shadow-sm transition">
                </div>
            </div>
        </div>
        <div class="flex flex-col gap-3">
            <h3 class="text-xl font-semibold text-gray-600">Información de Movilidad</h3>
            <div class="grid grid-cols-3 gap-4">
                <div class="flex flex-col gap-2">
                    <label for="modality" class="text-gray-500">Modalidad del Evento</label>
                    <select required name="modality" id="modality"
                        class="px-4 py-2 transition bg-white border border-green-300 rounded-lg shadow-sm">
                        <option disabled value="">Seleccione una modalidad</option>
                        <option value="presencial" @if ($event->modality == 'presencial') selected @endif>Presencial</option>
                        <option value="virtual" @if ($event->modality == 'virtual') selected @endif>Virtual</option>
                    </select>
                </div>

                <div class="flex-col {{ $event->modality === 'virtual' ? '' : 'hidden' }} gap-2" id="at_home">
                    <label for="internationalization_at_home" class="text-gray-500">Internacionalización en
                        Casa</label>
                    <select name="internationalization_at_home" id="internationalization_at_home"
                        class="px-4 py-2 transition bg-white border border-green-300 rounded-lg shadow-sm">
                        <option disabled value="">Seleccione una opción</option>
                        <option value="si" @if ($event->internationalization_at_home === 'si') selected @endif>Si</option>
                        <option value="no" @if ($event->internationalization_at_home === 'no') selected @endif>No</option>
                    </select>
                </div>

                <div class="flex flex-col gap-2">
                    <label for="location" class="text-gray-500">Localización del Evento</label>
                    <select required name="location" id="location"
                        class="px-4 py-2 transition bg-white border border-green-300 rounded-lg shadow-sm">
                        <option disabled value="">Seleccione una localización</option>
                        <option value="nacional" @if ($event->location == 'nacional') selected @endif>Nacional</option>
                        <option value="internacional" @if ($event->location == 'internacional') selected @endif>Internacional
                        </option>
                        <option value="local" @if ($event->location == 'local') selected @endif>Local</option>
                    </select>
                </div>

                <div class="flex flex-col gap-2 max-w-72">
                    <label for="university" class="text-gray-500">Universidad/es del Evento</label>
                    <select required id="university" class="w-full" name="universities[]" multiple>
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
                        class="px-4 py-2 transition bg-white border border-green-300 rounded-lg shadow-sm">
                        <option disabled value="">Seleccione una opción</option>
                        <option value="si" @if ($event->has_agreement == 'si') selected @endif>Si</option>
                        <option value="no" @if ($event->has_agreement == 'no') selected @endif>No</option>
                    </select>
                </div>

                <div class="flex-col {{ $event->has_agreement === 'si' ? '' : 'hidden' }} gap-2">
                    <label for="agreement_id" class="text-gray-500">Convenio</label>
                    <select name="agreement_id" id="agreement_id"
                        class="px-4 py-2 transition bg-white border border-green-300 rounded-lg shadow-sm">
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
                        class="px-4 py-2 transition bg-white border border-green-300 rounded-lg shadow-sm">
                        <option disabled value="">Seleccione una Actividad</option>
                        @foreach ($activities as $activity)
                            <option value="{{ $activity->id }}" @if ($event->activity_id == $activity->id) selected @endif>
                                {{ $activity->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-1">
                <div class="flex flex-row items-center justify-end gap-2">
                    <button type="submit"
                        class="inline-block px-4 py-2 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-green-700 from-green-500 hover:scale-95">
                        Actualizar Evento
                    </button>
                    <a href="{{ route('events') }}" type="button" popovertarget="create-event"
                        class="px-4 py-2 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-red-700 from-red-500 hover:scale-95">
                        Cancelar
                    </a>
                </div>
            </div>
        </div>
    </form>
</x-layouts.dashboard-layout>

@vite(['resources/js/modules/utils/conditionalSelect.js'])
@vite(['resources/js/modules/utils/multiSelectUtil.js'])
@vite(['resources/js/modules/utils/dateValidation.js'])
