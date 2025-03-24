<x-layouts.dashboard-layout>
    <div class="flex flex-row items-center justify-between my-4">
        <h2 class="text-2xl font-semibold text-green-700">
            Gestión de Actividades | Editar Actividad
        </h2>
    </div>

    <form action="{{ route('activities.update', $activity->id) }}" class="flex flex-col gap-6" method="POST">
        @csrf
        @method('PUT')

        <div class="flex flex-col gap-3">
            <h3 class="text-xl font-semibold text-gray-600">Información General</h3>
            <div class="grid grid-cols-1 gap-4">
                <div class="flex flex-col gap-2">
                    <label for="name" class="text-gray-500">Nombre</label>
                    <input required type="text" name="name" id="name" value="{{ $activity->name }}"
                        class="w-full px-4 py-2 transition bg-white border border-green-300 rounded-lg shadow-sm">
                </div>

                <div class="flex flex-col gap-2">
                    <label for="description" class="text-gray-500">Descripción</label>
                    <textarea required name="description" id="description" rows="3"
                        class="w-full px-4 py-2 transition bg-white border border-green-300 rounded-lg shadow-sm resize-none">{{ $activity->description }}</textarea>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1">
            <div class="flex flex-row items-center justify-end gap-2">
                <button type="submit"
                    class="inline-block px-4 py-2 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-green-700 from-green-500 hover:scale-95">
                    Actualizar Actividad
                </button>
                <a href="{{ route('activities') }}"
                    class="px-4 py-2 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-red-700 from-red-500 hover:scale-95">
                    Cancelar
                </a>
            </div>
        </div>
    </form>
</x-layouts.dashboard-layout>
