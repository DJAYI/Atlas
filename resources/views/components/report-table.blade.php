<details class="col-span-1 max-h-48 overflow-y-auto">
    <summary
        class="text-lg text-pretty flex items-center text-primary-700 px-3 py-2 border rounded-lg font-semibold hover:bg-primary-400 hover:text-white transition duration-75 cursor-pointer">
        Reportes de Movilidad de Eventos de {{ $title }}
    </summary>


    <table
        class="w-full   text-sm text-left text-gray-500 rtl:text-center border-b border-l border-r border-gray-300 rounded-b-lg border-separate">
        <thead>
            <tr>
                <th class="px-4 py-2 text-center">Evento</th>
                <th class="px-4 py-2 text-center">Total Asistentes</th>
                <th class="px-4 py-2 text-center">Fecha</th>
                <th class="px-4 py-2 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($filteredEvents as $event)
                <tr>
                    <td class="px-4 py-2 text-center">{{ $event->name }}</td>
                    <td class="px-4 py-2 text-center">{{ $event->assistances->count() }}</td>
                    <td class="px-4 py-2 text-center">{{ \Carbon\Carbon::parse($event->end_date)->format('d/m/Y') }}</td>
                    <td class="px-4 py-2 text-center">
                        <form method="POST"
                            action="{{ route('generate.report', [
                                'event_id' => $event->id,
                                'type' => $type,
                                'is_colombian' => $isColombian,
                            ]) }}">
                            @csrf
                            <button type="submit"
                                class="px-4 py-2 font-semibold text-xs text-white transition rounded-lg bg-gradient-to-tr from-blue-500 to-blue-700 hover:shadow-[1px_1px_20px] hover:shadow-blue-400/65 hover:bg-blend-darken hover:bg-primary-500">
                                Generar Reporte
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</details>
