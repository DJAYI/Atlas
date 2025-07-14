<div class="flex flex-col items-center w-full">
    <div class="flex items-center justify-between w-full px-4 py-2 mt-4 bg-white border rounded-lg">
        <h2 class="text-2xl font-semibold text-pretty text-primary-700">
            Reporte Completo de Asistencias
            @if ($totalCount > 0)
                <span class="text-sm text-gray-500">({{ number_format($totalCount) }} registros totales)</span>
            @endif
        </h2>
        <div class="flex items-center gap-2">
            <button wire:click="downloadExcel"
                class="px-4 py-2 font-semibold text-white transition rounded-lg bg-gradient-to-tr from-blue-500 to-blue-700 hover:shadow-[1px_1px_20px] hover:shadow-blue-400/65 hover:bg-blend-darken hover:bg-primary-500"
                wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="downloadExcel">Generar Reporte</span>
                <span wire:loading wire:target="downloadExcel">Generando...</span>
            </button>
        </div>
    </div>

    <!-- Controles de búsqueda y filtros -->
    <div class="flex items-center justify-between w-full px-4 py-3 mt-2 bg-white border rounded-lg">
        <div class="flex items-center gap-4">
            <div class="relative">
                <input type="text" wire:model.debounce.300ms="search"
                    placeholder="Buscar por nombre, email, documento o evento..."
                    class="px-4 py-2 pl-10 border rounded-lg w-80 focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                <svg class="absolute w-4 h-4 text-gray-400 left-3 top-3" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>

            <button wire:click="$set('search', '')" class="text-sm text-gray-500 hover:text-gray-700">
                Limpiar búsqueda
            </button>
        </div>

        <div class="flex items-center gap-4">
            <label class="flex items-center gap-2">
                <span class="text-sm text-gray-700">Registros por página:</span>
                <select wire:model="perPage" class="px-3 py-1 border rounded">
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </label>

            <button wire:click="toggleShowAll"
                class="px-3 py-1 text-sm border rounded hover:bg-gray-50 {{ $showAll ? 'bg-primary-100 text-primary-700' : '' }}">
                {{ $showAll ? 'Mostrar paginado' : 'Mostrar todos' }}
            </button>
        </div>
    </div>

    <!-- Loading indicator -->
    <div wire:loading.delay wire:target="search,perPage,toggleShowAll" class="w-full">
        <div class="flex items-center justify-center py-4">
            <div class="w-8 h-8 border-b-2 rounded-full animate-spin border-primary-600"></div>
            <span class="ml-2 text-gray-600">Cargando...</span>
        </div>
    </div>

    <!-- Tabla optimizada -->
    <div class="overflow-auto max-h-[600px] max-w-full" wire:loading.remove wire:target="search,perPage,toggleShowAll">
        @if ($assistances instanceof \Illuminate\Pagination\LengthAwarePaginator)
            @if ($assistances->count() > 0)
                <table class="text-sm text-center text-gray-500 rounded-lg">
                    <thead class="sticky top-0 z-10 bg-white">
                        <tr class="px-2 py-1 text-sm font-semibold text-gray-700 uppercase bg-gray-100">
                            <th class="px-2 py-1 border">FECHA</th>
                            <th class="px-2 py-1 border">GENERO</th>
                            <th class="px-2 py-1 border">COMUNIDAD</th>
                            <th class="px-2 py-1 border">CORREO ELECTRÓNICO</th>
                            <th class="px-2 py-1 border">NOMBRE Y APELLIDOS</th>
                            <th class="px-2 py-1 border">TIPO DE IDENTIFICACIÓN</th>
                            <th class="px-2 py-1 border">N° IDENTIFICACIÓN</th>
                            <th class="px-2 py-1 border">FECHA DE NACIMIENTO</th>
                            <th class="px-2 py-1 border">TELÉFONO</th>
                            <th class="px-2 py-1 border">INSTITUCIÓN</th>
                            <th class="px-2 py-1 border">PROGRAMA</th>
                            <th class="px-2 py-1 border">TIPO DE MODALIDAD</th>
                            <th class="px-2 py-1 border">TIPO DE PARTICIPACION</th>
                            <th class="px-2 py-1 border">NOMBRE DEL EVENTO</th>
                            <th class="px-2 py-1 border">NACIONALIDAD</th>
                            <th class="px-2 py-1 border">E/S</th>
                            <th class="px-2 py-1 border">MOVILIDAD</th>
                            <th class="px-2 py-1 border">TIPO DE ASISTENTE</th>
                            <th class="px-2 py-1 border">PROGRAMA DEL EVENTO</th>
                            <th class="px-2 py-1 border">DESCRIPCIÓN DEL EVENTO</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($assistances as $assistance)
                            <tr class="transition hover:bg-gray-50">
                                <td class="px-2 py-1 border">{{ $assistance->created_at->format('d/m/Y') }}</td>
                                <td class="px-2 py-1 border">{{ $assistance->person->genre }}</td>
                                <td class="px-2 py-1 border">{{ $assistance->person->minority ?? 'ninguna' }}</td>
                                <td class="px-2 py-1 border">{{ $assistance->person->email }}</td>
                                <td class="px-2 py-1 border">
                                    {{ $assistance->person->firstname . ' ' . ($assistance->person->middlename ?? '') . ' ' . $assistance->person->lastname . ' ' . ($assistance->person->second_lastname ?? '') }}
                                </td>
                                <td class="px-2 py-1 border">{{ $assistance->person->document_type }}</td>
                                <td class="px-2 py-1 border">{{ $assistance->person->document_number }}</td>
                                <td class="px-2 py-1 border">
                                    {{ $assistance->person->birth_date ? $assistance->person->birth_date->format('d/m/Y') : 'N/A' }}
                                </td>
                                <td class="px-2 py-1 border">{{ $assistance->person->phone }}</td>
                                <td class="px-2 py-1 border">{{ $assistance->person->university->name }}</td>
                                <td class="px-2 py-1 border">{{ $assistance->person->career->name }}</td>
                                <td class="px-2 py-1 border">{{ $assistance->event->modality }}</td>
                                <td class="px-2 py-1 border">{{ $assistance->event->activity->name }}</td>
                                <td class="px-2 py-1 border">{{ $assistance->event->name }}</td>
                                <td class="px-2 py-1 border">{{ $assistance->person->country->name }}</td>
                                <td class="px-2 py-1 border">
                                    {{ $assistance->person->university->name === 'Fundación Universitaria Tecnológico Comfenalco' ? 'S' : 'E' }}
                                </td>
                                <td class="px-2 py-1 border">{{ $assistance->mobility->name }}</td>
                                <td class="px-2 py-1 border">{{ $assistance->mobility->type }}</td>
                                <td class="px-2 py-1 border">
                                    {{ $assistance->event->career ? $assistance->event->career->name : 'N/A' }}
                                </td>
                                <td class="px-2 py-1 border">{{ $assistance->event->description }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Paginación -->
                <div class="mt-4">
                    {{ $assistances->links() }}
                </div>
            @else
                <div class="flex items-center justify-center py-8">
                    <p class="text-gray-500">No se encontraron registros que coincidan con la búsqueda.</p>
                </div>
            @endif
        @else
            {{-- Vista para mostrar todos --}}
            @if ($assistances->count() > 0)
                <table class="text-sm text-center text-gray-500 rounded-lg">
                    <thead class="sticky top-0 z-10 bg-white">
                        <tr class="px-2 py-1 text-sm font-semibold text-gray-700 uppercase bg-gray-100">
                            <th class="px-2 py-1 border">FECHA</th>
                            <th class="px-2 py-1 border">GENERO</th>
                            <th class="px-2 py-1 border">COMUNIDAD</th>
                            <th class="px-2 py-1 border">CORREO ELECTRÓNICO</th>
                            <th class="px-2 py-1 border">NOMBRE Y APELLIDOS</th>
                            <th class="px-2 py-1 border">TIPO DE IDENTIFICACIÓN</th>
                            <th class="px-2 py-1 border">N° IDENTIFICACIÓN</th>
                            <th class="px-2 py-1 border">FECHA DE NACIMIENTO</th>
                            <th class="px-2 py-1 border">TELÉFONO</th>
                            <th class="px-2 py-1 border">INSTITUCIÓN</th>
                            <th class="px-2 py-1 border">PROGRAMA</th>
                            <th class="px-2 py-1 border">TIPO DE MODALIDAD</th>
                            <th class="px-2 py-1 border">TIPO DE PARTICIPACION</th>
                            <th class="px-2 py-1 border">NOMBRE DEL EVENTO</th>
                            <th class="px-2 py-1 border">NACIONALIDAD</th>
                            <th class="px-2 py-1 border">E/S</th>
                            <th class="px-2 py-1 border">MOVILIDAD</th>
                            <th class="px-2 py-1 border">TIPO DE ASISTENTE</th>
                            <th class="px-2 py-1 border">PROGRAMA DEL EVENTO</th>
                            <th class="px-2 py-1 border">DESCRIPCIÓN DEL EVENTO</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($assistances as $assistance)
                            <tr class="transition hover:bg-gray-50">
                                <td class="px-2 py-1 border">{{ $assistance->created_at->format('d/m/Y') }}</td>
                                <td class="px-2 py-1 border">{{ $assistance->person->genre }}</td>
                                <td class="px-2 py-1 border">{{ $assistance->person->minority ?? 'ninguna' }}</td>
                                <td class="px-2 py-1 border">{{ $assistance->person->email }}</td>
                                <td class="px-2 py-1 border">
                                    {{ $assistance->person->firstname . ' ' . ($assistance->person->middlename ?? '') . ' ' . $assistance->person->lastname . ' ' . ($assistance->person->second_lastname ?? '') }}
                                </td>
                                <td class="px-2 py-1 border">{{ $assistance->person->document_type }}</td>
                                <td class="px-2 py-1 border">{{ $assistance->person->document_number }}</td>
                                <td class="px-2 py-1 border">
                                    {{ $assistance->person->birth_date ? $assistance->person->birth_date->format('d/m/Y') : 'N/A' }}
                                </td>
                                <td class="px-2 py-1 border">{{ $assistance->person->phone }}</td>
                                <td class="px-2 py-1 border">{{ $assistance->person->university->name }}</td>
                                <td class="px-2 py-1 border">{{ $assistance->person->career->name }}</td>
                                <td class="px-2 py-1 border">{{ $assistance->event->modality }}</td>
                                <td class="px-2 py-1 border">{{ $assistance->event->activity->name }}</td>
                                <td class="px-2 py-1 border">{{ $assistance->event->name }}</td>
                                <td class="px-2 py-1 border">{{ $assistance->person->country->name }}</td>
                                <td class="px-2 py-1 border">
                                    {{ $assistance->person->university->name === 'Fundación Universitaria Tecnológico Comfenalco' ? 'S' : 'E' }}
                                </td>
                                <td class="px-2 py-1 border">{{ $assistance->mobility->name }}</td>
                                <td class="px-2 py-1 border">{{ $assistance->mobility->type }}</td>
                                <td class="px-2 py-1 border">
                                    {{ $assistance->event->career ? $assistance->event->career->name : 'N/A' }}
                                </td>
                                <td class="px-2 py-1 border">{{ $assistance->event->description }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="flex items-center justify-center py-8">
                    <p class="text-gray-500">No hay registros disponibles.</p>
                </div>
            @endif
        @endif
    </div>
</div>
