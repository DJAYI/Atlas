<x-layouts.dashboard-layout>
    <div class="flex flex-row items-center justify-between my-4">
        <h2 class="text-2xl font-semibold text-primary-700">
            Gestión de Convenios | Editar Convenio
        </h2>
    </div>

    <form action="{{ route('agreements.update', $agreement->id) }}" class="flex flex-col gap-6" method="POST">
        @csrf
        @method('PUT')

        <div class="flex flex-col gap-6">
            <h3 class="text-xl font-semibold text-gray-600">Información General</h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col gap-2">
                    <label for="year" class="text-gray-500">Año</label>
                    <input required maxlength="4" type="text" name="year" id="year"
                        value="{{ old('year', $agreement->year) }}"
                        class="w-full px-4 py-2 transition bg-white border border-primary-300 rounded-lg shadow-sm">
                </div>
                <div class="flex flex-col gap-2">
                    <label for="semester" class="text-gray-500">Periodo</label>
                    <input required maxlength="1" type="text" name="semester" id="semester"
                        value="{{ old('semester', $agreement->semester) }}"
                        class="w-full px-4 py-2 transition bg-white border border-primary-300 rounded-lg shadow-sm">
                </div>
            </div>
            <div class="flex flex-col gap-3">
                <h3 class="text-xl font-semibold text-gray-600">Información del Convenio</h3>
                <div class="grid grid-cols-3 gap-4">
                    <div class="flex flex-col gap-2">
                        <label for="code" class="text-gray-500">Código</label>
                        <input required maxlength="6" type="text" name="code" id="code"
                            value="{{ old('code', $agreement->code) }}"
                            class="w-full px-4 py-2 transition bg-white border border-primary-300 rounded-lg shadow-sm">
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="type" class="text-gray-500">Tipo de Convenio</label>
                        <select required name="type" id="type"
                            class="px-4 py-2 transition bg-white border border-primary-300 rounded-lg shadow-sm">
                            <option value="" disabled>Seleccione un tipo</option>
                            <option value="marco" {{ old('type', $agreement->type) === 'marco' ? 'selected' : '' }}>
                                Marco</option>
                            <option value="especifico"
                                {{ old('type', $agreement->type) === 'especifico' ? 'selected' : '' }}>Específico
                            </option>
                        </select>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="activity" class="text-gray-500">Tipo de Actividad</label>
                        <select required name="activity" id="activity"
                            class="px-4 py-2 transition bg-white border border-primary-300 rounded-lg shadow-sm">
                            <option value="" disabled>Seleccione una actividad</option>
                            <option value="formacion"
                                {{ old('activity', $agreement->activity) === 'formacion' ? 'selected' : '' }}>Formación
                            </option>
                            <option value="investigacion"
                                {{ old('activity', $agreement->activity) === 'investigacion' ? 'selected' : '' }}>
                                Investigación</option>
                            <option value="extension"
                                {{ old('activity', $agreement->activity) === 'extension' ? 'selected' : '' }}>Extensión
                            </option>
                            <option value="administrativa"
                                {{ old('activity', $agreement->activity) === 'administrativa' ? 'selected' : '' }}>
                                Administrativa</option>
                            <option value="otra"
                                {{ old('activity', $agreement->activity) === 'otra' ? 'selected' : '' }}>Otra</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-3">
                <h3 class="text-xl font-semibold text-gray-600">Durabilidad del Convenio</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-2">
                        <label for="start_date" class="text-gray-500">Fecha de Inicio</label>
                        <input required type="date" name="start_date" id="start_date" min="{{ date('Y-m-d') }}"
                            value="{{ old('start_date', $agreement->start_date ? $agreement->start_date->format('Y-m-d') : '') }}"
                            class="w-full px-4 py-2 transition bg-white border border-primary-300 rounded-lg shadow-sm">
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="end_date" class="text-gray-500">Fecha de Fin</label>
                        <input required type="date" name="end_date" id="end_date" min="{{ date('Y-m-d') }}"
                            value="{{ old('end_date', $agreement->end_date ? $agreement->end_date->format('Y-m-d') : '') }}"
                            class="w-full px-4 py-2 transition bg-white border border-primary-300 rounded-lg shadow-sm">
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1">
                <div class="flex flex-row items-center justify-end gap-2">
                    <button type="submit"
                        class="inline-block px-4 py-2 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-primary-700 from-primary-500 hover:scale-95">
                        Actualizar Convenio
                    </button>
                    <a href="{{ route('agreements') }}"
                        class="px-4 py-2 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-red-700 from-red-500 hover:scale-95">
                        Cancelar
                    </a>
                </div>
            </div>
        </div>
    </form>
</x-layouts.dashboard-layout>

<script src="{{ asset('js/modules/utils/dateValidation.js') }}"></script>
