@props(['faculties' => []])

{{-- Create event Modal --}}

<div class="flex-col max-h-screen gap-4 px-5 py-8 transition bg-white shadow-lg backdrop:backdrop-blur-sm backdrop:backdrop-brightness-75 rounded-xl"
    id="create-career" popover>
    <h3 class="text-4xl font-semibold">Nuevo Programa</h3>
    <br>
    <form action="{{ route('careers.store') }}" class="flex flex-col gap-6" method="POST">
        @csrf
        @method('POST')

        <div class="flex flex-col gap-3">
            <h3 class="text-xl font-semibold text-gray-600">Información General</h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col gap-2">
                    <label for="name" class="text-gray-500">Nombre</label>
                    <input required type="text" name="name" id="name"
                        class="py-2 px-4 w-[400px] bg-white border border-green-300 rounded-lg shadow-sm  transition">
                </div>

                <div class="flex flex-col gap-2">
                    <label for="faculty_id" class="text-gray-500">Facultad</label>
                    <select required name="faculty_id" id="faculty_id"
                        class="px-4 py-2 transition w-[400px] bg-white border border-green-300 rounded-lg shadow-sm">
                        <option value="" disabled selected>Seleccione una facultad</option>

                        @foreach ($faculties as $faculty)
                            <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col gap-2">
                    <label for="description" class="text-gray-500">Descripción</label>
                    <textarea required name="description" id="description" rows="3"
                        class="py-2 resize-none px-4 w-[400px] bg-white border border-green-300 rounded-lg shadow-sm  transition"></textarea>
                </div>

            </div>
            <div class="grid grid-cols-1">
                <div class="flex flex-row items-center justify-end gap-2">
                    <button type="submit"
                        class="inline-block px-4 py-2 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-green-700 from-green-500 hover:scale-95">
                        Crear Evento
                    </button>
                    <button type="button" popovertarget="create-career"
                        class="px-4 py-2 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-red-700 from-red-500 hover:scale-95">
                        Cancelar
                    </button>
                </div>
            </div>
    </form>
</div>
