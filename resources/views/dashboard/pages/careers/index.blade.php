<x-layouts.dashboard-layout>
    <div class="flex flex-row items-center justify-between my-4">
        <h2 class="text-2xl font-semibold text-primary-700">
            Gestión de Programas </h2>

        <button
            class="inline-block px-4 py-2 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-primary-700 from-primary-500 hover:scale-95"
            popovertarget="create-career">
            Crear Programa
        </button>
    </div>
    <br>
    <div class="flex flex-row justify-between mx-5">
        <h3 class="text-lg font-semibold">Todos los Programas</h3>

        <div class="relative sm:w-1/2">
            <input required type="text" placeholder="Buscar convenio" id="filter-search"
                class="w-full px-4 py-2 pl-10 pr-4 placeholder-gray-500 transition bg-white border border-primary-300 rounded-lg shadow-sm">
            <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
    </div>
    <br>
    <table class="w-full text-sm text-left text-gray-500 rtl:text-right">
        <thead class="text-gray-700 uppercase">
            <tr>
                <th scope="col" class="px-6 py-3">Nombre</th>
                <th scope="col" class="px-6 py-3">Descripción</th>
                <th scope="col" class="px-6 py-3">Facultad</th>
                <th scope="col" class="px-6 py-3">Acciones</th>
            </tr>
        </thead>

        <tbody id="table-data">
            @foreach ($careersPaginated as $career)
                <tr>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        {{ $career->name }}
                    </td>

                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        {{ $career->description }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $career->faculty->name }}
                    </td>

                    <td class="px-6 py-4">
                        <a href="{{ route('careers.edit', $career->id) }}"
                            class="inline-block inline-block px-4 py-2 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-primary-700 from-primary-500 hover:scale-95"
                            popovertarget="edit-career" popoverdata="{{ $career->id }}">Ver más</a>
                        <form action="{{ route('careers.destroy', $career->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-4 py-2 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-red-700 from-red-500 hover:scale-95"
                                popovertarget="delete-career" popoverdata="{{ $career->id }}">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach

            @if ($careersPaginated->isEmpty())
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center">
                        No hay programas disponibles.
                    </td>
                </tr>
            @endif

        </tbody>
    </table>

    {{ $careersPaginated->links() }}
</x-layouts.dashboard-layout>
<x-modals.create-career-modal faculties={{ $faculties }} />

@vite(['resources/js/modules/utils/filterSearch.js'])
