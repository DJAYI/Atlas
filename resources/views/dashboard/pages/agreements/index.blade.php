<x-layouts.dashboard-layout>
    <div class="flex flex-row items-center justify-between my-4">
        <h2 class="text-2xl font-semibold text-green-700">
            Gestión de Convenios
        </h2>

        <button
            class="inline-block px-4 py-2 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-green-700 from-green-500 hover:scale-95"
            popovertarget="create-agreement">
            Crear Convenio
        </button>
    </div>
    <br>

    <div class="flex flex-row justify-between mx-5">
        <h3 class="text-lg font-semibold">Todos los Convenios</h3>

        <div class="relative sm:w-1/2">
            <input required type="text" placeholder="Buscar convenio" id="filter-search"
                class="w-full px-4 py-2 pl-10 pr-4 placeholder-gray-500 transition bg-white border border-green-300 rounded-lg shadow-sm">
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
                <th scope="col" class="px-6 py-3">Año</th>
                <th scope="col" class="px-6 py-3">Periodo</th>
                <th scope="col" class="px-6 py-3">Código</th>
                <th scope="col" class="px-6 py-3">Tipo</th>
                <th scope="col" class="px-6 py-3">Actividad</th>
                <th scope="col" class="px-6 py-3">Fecha</th>
                <th scope="col" class="px-6 py-3">Acciones</th>

            </tr>
        </thead>
        <tbody id="table-data">
            @foreach ($agreementsPaginated as $agreement)
                <tr>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        {{ $agreement->year }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        {{ $agreement->semester }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $agreement->code }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $agreement->type }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $agreement->activity }}
                    </td>
                    <td class="px-6 py-4">
                        {{ \Carbon\Carbon::parse($agreement->start_date)->format('d/m/Y') }} -
                        {{ \Carbon\Carbon::parse($agreement->end_date)->format('d/m/Y') }}
                    </td>

                    <td class="px-6 py-4">
                        <a href="{{ route('agreements.edit', $agreement->id) }}"
                            class="inline-block inline-block px-4 py-2 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-green-700 from-green-500 hover:scale-95"
                            popovertarget="edit-university" popoverdata="{{ $agreement->id }}">Ver más</a>
                        <form action="{{ route('agreements.destroy', $agreement->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-4 py-2 font-semibold text-white transition rounded-lg shadow-md bg-gradient-to-bl to-red-700 from-red-500 hover:scale-95"
                                popovertarget="delete-university" popoverdata="{{ $agreement->id }}">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            @if ($agreementsPaginated->isEmpty())
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                        No hay Convenios registrados
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
    {{ $agreementsPaginated->links() }}
</x-layouts.dashboard-layout>

<x-modals.create-agreement-modal />
@vite(['resources/js/modules/utils/filterSearch.js'])
