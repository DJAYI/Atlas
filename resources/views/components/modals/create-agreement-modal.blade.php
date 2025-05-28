{{-- Create event Modal --}}
<div class="max-h-screen gap-4 px-5 py-8 transition bg-white shadow-lg backdrop:backdrop-blur-sm backdrop:backdrop-brightness-75 rounded-xl"
    id="create-agreement" popover>
    <h3 class="text-4xl font-semibold">Nuevo Convenio</h3>
    <br>
    <form action="{{ route('agreements.store') }}" class="flex flex-col gap-6" method="POST">
        @csrf
        @method('POST')

        <div class="flex flex-col gap-6">
            <h3 class="text-xl font-semibold text-gray-600">Información General</h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col gap-2">
                    <label for="year" class="text-gray-500">Año</label>
                    <input required maxlength="4" type="text" name="year" id="year"
                        class="py-2 px-4 w-[400px] bg-white border border-primary-300 rounded-lg shadow-sm  transition">
                </div>
                <div class="flex flex-col gap-2">
                    <label for="semester" class="text-gray-500">Periodo</label>
                    <input required maxlength="1" type="text" name="semester" id="semester"
                        class="py-2 px-4 w-[400px] bg-white border border-primary-300 rounded-lg shadow-sm  transition">
                </div>



            </div>
            <div class="flex flex-col gap-3">
                <h3 class="text-xl font-semibold text-gray-600">Información del Convenio</h3>
                <div class="grid grid-cols-3 gap-4">
                    <div class="flex flex-col gap-2">
                        <label for="code" class="text-gray-500">Código</label>
                        <input required maxlength="6" type="text" name="code" id="code"
                            class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300">
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="type" class="text-gray-500">Tipo de Convenio</label>
                        <select required name="type" id="type"
                            class="px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300">
                            <option selected disabled value="">Seleccione un tipo</option>
                            <option value="marco">Marco</option>
                            <option value="especifico">Específico</option>
                        </select>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="activity" class="text-gray-500">Tipo de Actividad</label>
                        <select required name="activity" id="activity"
                            class="px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300">
                            <option selected disabled value="">Seleccione una actividad</option>
                            <option value="formacion">Formacion</option>
                            <option value="investigacion">Investigación</option>
                            <option value="extension">Extensión</option>
                            <option value="administrativa">Administrativa</option>
                            <option value="otra">Otra</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-3">
                <h3 class="text-xl font-semibold text-gray-600">Durabilidad del Convenio</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-2">
                        <label for="start_date" class="text-gray-500">Fecha de Inicio</label>
                        <input required type="date" min="{{ date('Y-m-d') }}" name="start_date" id="start_date"
                            class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300">
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="end_date" class="text-gray-500">Fecha de Fin</label>
                        <input required type="date" min="{{ date('Y-m-d') }}" name="end_date" id="end_date"
                            class="w-full px-4 py-2 transition bg-white border rounded-lg shadow-sm border-primary-300">
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1">
                <div class="flex flex-row items-center justify-end gap-2">
                    <button type="submit"
                        class="inline-block px-4 py-2 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-primary-700 from-primary-500 hover:scale-95">
                        Crear Convenio
                    </button>
                    <button type="button" popovertarget="create-agreement"
                        class="px-4 py-2 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-red-700 from-red-500 hover:scale-95">
                        Cancelar
                    </button>
                </div>
            </div>
    </form>
</div>
<script src="{{ asset('js/modules/utils/dateValidation.js') }}"></script>
