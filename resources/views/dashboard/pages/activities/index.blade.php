<x-layouts.dashboard-layout>
    <div class="flex flex-row items-center justify-between my-4">
        <h2 class="text-2xl font-semibold text-green-700">
            Gestión de Actividades
        </h2>
        <button
            class="inline-block px-4 py-2 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-green-700 from-green-500 hover:scale-95"
            popovertarget="create-activity">
            Crear Actividad
        </button>
    </div>
    <br>
    <div class="flex flex-row justify-between">
        <h3 class="text-lg font-semibold">Todos los eventos</h3>

        <div class="relative sm:w-1/2">

            <input required type="text" placeholder="Buscar evento" id="filter-search"
                class="w-full px-4 py-2 pl-10 pr-4 placeholder-gray-500 transition bg-white border border-green-300 rounded-lg shadow-sm">
            <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
    </div>
    <table class="w-full text-sm text-center text-gray-500 rtl:text-right">
        <thead class="text-gray-700 uppercase">
            <tr>
                <th scope="col" class="px-6 py-3">ID</th>
                <th scope="col" class="px-6 py-3">Nombre</th>
                <th scope="col" class="px-6 py-3">Descripción</th>
                <th scope="col" class="px-6 py-3">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($activitiesPaginated as $activity)
                <tr>
                    <td colspan="1" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        {{ $activity->id }}
                    </td>
                    <td colspan="1" class="px-6 py-4">
                        {{ $activity->name }}
                    </td>
                    <td colspan="1" class="px-6 py-4">
                        {{ $activity->description }}
                    </td>
                    <td colspan="1" class="px-6 py-4">
                        <a href="{{ route('activities.edit', $activity->id) }}"
                            class="inline-block px-4 py-2 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-green-700 from-green-500 hover:scale-95"
                            popovertarget="edit-activity" popoverdata="{{ $activity->id }}">Ver más</a>
                        <form action="{{ route('activities.destroy', $activity->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-4 py-2 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-red-700 from-red-500 hover:scale-95"
                                popovertarget="delete-activity" popoverdata="{{ $activity->id }}">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach

            @if ($activitiesPaginated->isEmpty())
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                        No hay actividades registradas
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="mt-4">
        {{ $activitiesPaginated->links() }}
    </div>
    <x-modals.create-activity-modal></x-modals.create-activity-modal>
</x-layouts.dashboard-layout>

@vite(['resources/js/modules/utils/filterSearch.js'])
