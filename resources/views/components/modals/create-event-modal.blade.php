@props(['universities' => [], 'agreements' => [], 'activities' => [], 'careers' => []])


{{-- Create event Modal --}}
<div class="max-w-4xl max-h-screen gap-4 px-5 py-8 transition bg-white shadow-lg backdrop:backdrop-blur-sm backdrop:backdrop-brightness-75 rounded-xl"
    id="create-event" popover>
    <h3 class="text-4xl font-semibold">Nuevo Evento</h3>
    <br>
    <form action="{{ route('events.store') }}" class="flex flex-col gap-6" method="POST">
        @csrf
        @method('POST')

        <x-validation-errors class="mb-4" :errors="$errors" />

        <div class="flex flex-col gap-3">
            <h3 class="text-xl font-semibold text-gray-600">Información General</h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col gap-2">
                    <label for="name" class="text-gray-500">Nombre del evento</label>
                    <input required type="text" name="name" id="name"
                        placeholder="Ingrese el nombre del evento"
                        class="py-2 px-4 w-[400px] bg-white border border-primary-300 rounded-lg shadow-sm  transition">
                    <small class="text-gray-400">Ingrese el nombre completo del evento</small>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="responsable" class="text-gray-500">Responsable del evento</label>
                    <input required type="text" name="responsable" id="responsable"
                        placeholder="Ingrese el nombre del responsable"
                        class="py-2 px-4 w-[400px] bg-white border border-primary-300 rounded-lg shadow-sm  transition">
                    <small class="text-gray-400">Indique quién será el responsable del evento</small>
                </div>

            </div>
        </div>
        <div class="flex flex-col gap-3">
            <h3 class="text-xl font-semibold text-gray-600">Fechas y Horarios</h3>
            <div class="grid grid-cols-4 gap-4">
                <div class="flex flex-col gap-2">
                    <label for="start_date" class="text-gray-500">Fecha de Inicio</label>
                    <input required type="date" name="start_date" id="start_date" min="{{ date('Y-m-d') }}"
                        placeholder="Seleccione la fecha de inicio"
                        class="py-2 px-4 w-[200px] bg-white border border-primary-300 rounded-lg shadow-sm  transition">
                    <small class="text-gray-400">Seleccione la fecha en la que comenzará el evento</small>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="end_date" class="text-gray-500">Fecha de Fin</label>
                    <input required type="date" name="end_date" id="end_date" min="{{ date('Y-m-d') }}"
                        placeholder="Seleccione la fecha de fin"
                        class="py-2 px-4 w-[200px] bg-white border border-primary-300 rounded-lg shadow-sm  transition">
                    <small class="text-gray-400">Seleccione la fecha en la que finalizará el evento</small>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="start_time" class="text-gray-500">Hora de Inicio</label>
                    <input required type="time" name="start_time" id="start_time"
                        placeholder="Seleccione la hora de inicio"
                        class="py-2 px-4 w-[200px] bg-white border border-primary-300 rounded-lg shadow-sm  transition">
                    <small class="text-gray-400">Indique la hora en la que comenzará el evento</small>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="end_time" class="text-gray-500">Hora de Fin</label>
                    <input required type="time" name="end_time" id="end_time"
                        placeholder="Seleccione la hora de fin"
                        class="py-2 px-4 w-[200px] bg-white border border-primary-300 rounded-lg shadow-sm  transition">
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
                        class="px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300">
                        <option selected disabled value="">Seleccione una modalidad</option>
                        <option value="presencial">Presencial</option>
                        <option value="virtual">Virtual</option>
                    </select>
                    <small class="text-gray-400">Seleccione si el evento será presencial o virtual</small>
                </div>

                <div class="flex-col hidden gap-2" id="at_home">
                    <label for="internationalization_at_home" class="text-gray-500 ">Internacionalización en
                        Casa</label>
                    <select name="internationalization_at_home" id="internationalization_at_home"
                        class="px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300 ">
                        <option selected disabled>Seleccione una opción</option>
                        <option value="si">Si</option>
                        <option value="no">No</option>
                    </select>

                    <small class="text-gray-400">Solo si el evento es realizada dentro de la Fundación Universitaria
                        Tecnológico Comfenalco</small>
                </div>

                <div class="flex flex-col gap-2">
                    <label for="location" class="text-gray-500">Localización del Evento</label>
                    <select required name="location" id="location"
                        class="px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300">
                        <option selected disabled value="">Seleccione una localización</option>
                        <option value="nacional">Nacional</option>
                        <option value="internacional">Internacional</option>
                        <option value="local">Local</option>
                    </select>
                    <small class="text-gray-400">Indique si el evento será nacional, internacional o local</small>
                </div>

                <div class="flex flex-col gap-2 max-w-72">
                    <label for="university" class="text-gray-500">Universidad/es del Evento</label>
                    <select required name="universities[]" id="university" class="w-full" name="universities"
                        multiple>
                        <option disabled>Seleccione una universidad</option>
                        @foreach ($universities as $university)
                            <option value="{{ $university->id }}">{{ $university->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="flex flex-col gap-3">
            <h3 class="text-xl font-semibold text-gray-600">Información Adicional</h3>
            <div class="grid grid-cols-3 gap-4">

                <div class="flex flex-col col-span-1 gap-2">
                    <label for="agreement" class="text-gray-500">¿Tiene Convenio?</label>
                    <select name="has_agreement" required id="has_agreement"
                        class="px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300">
                        <option selected disabled value="">Seleccione una opción</option>
                        <option value="si">Si</option>
                        <option value="no">No</option>
                    </select>
                </div>

                <div class="flex-col hidden col-span-1 gap-2">
                    <label for="agreement_id" class="text-gray-500">Convenio</label>
                    <select name="agreement_id" id="agreement_id"
                        class="px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300">
                        <option selected disabled value="">Seleccione un convenio</option>
                        @foreach ($agreements as $agreement)
                            <option value="{{ $agreement->id }}">{{ $agreement->code }}</option>
                        @endforeach
                    </select>
                    <small class="text-gray-400">Seleccione el convenio asociado al evento, si aplica</small>
                </div>

                <div class="flex flex-col col-span-1 gap-2">
                    <label for="activity_id" class="text-gray-500">Actividad</label>
                    <select name="activity_id" id="activity_id"
                        class="px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300">
                        <option selected disabled value="">Seleccione una Actividad</option>
                        @foreach ($activities as $activity)
                            <option value="{{ $activity->id }}">{{ $activity->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col col-span-1 gap-2">
                    <label for="career_id" class="text-gray-500">Carrera</label>
                    <select name="career_id" id="career_id" required
                        class="px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300">
                        <option selected disabled value="">Seleccione una carrera</option>
                        @foreach ($careers as $career)
                            <option value="{{ $career->id }}">{{ $career->name }}</option>
                        @endforeach
                    </select>
                    <small class="text-gray-400">Seleccione la carrera asociada al evento</small>
                </div>

                <div class="flex flex-col col-span-3 gap-2">
                    <label for="description" class="text-gray-500">Descripción del Evento</label>
                    <textarea name="description" id="description" rows="4" maxlength="1000"
                        class="px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300"
                        placeholder="Escriba el nombre del invitado, la universidad a la que pertenece, su última formación académica y un breve perfil profesional. Indique también el tema a tratar y qué se busca fomentar en los asistentes (estudiantes, docentes, egresados, entre otros)."></textarea>
                    <small class="text-gray-400">Máximo 150 palabras. Sea conciso y claro en su descripción.</small>
                </div>
            </div>
            <div class="grid grid-cols-1">
                <div class="flex flex-row items-center justify-end gap-2">
                    <button type="submit"
                        class="inline-block px-4 py-2 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-primary-700 from-primary-500 hover:scale-95">
                        Crear Evento
                    </button>
                    <button type="button" popovertarget="create-event"
                        class="px-4 py-2 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-red-700 from-red-500 hover:scale-95">
                        Cancelar
                    </button>
                </div>

            </div>
        </div>
    </form>
</div>

<script src="{{ asset('js/modules/utils/conditionalSelect.js') }}"></script>
<script src="{{ asset('js/modules/utils/multiSelectUtil.js') }}"></script>
<script src="{{ asset('js/modules/utils/dateValidation.js') }}"></script>
