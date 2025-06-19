@php
    $rows = [
        [
            'label' => 'N° de asistentes Presencial (Internacional)',
            'key' => 'Internacional Presencial',
            'rowClass' => 'bg-gray-50 text-center',
        ],
        [
            'label' => 'N° de asistentes Presencial (Nacional)',
            'key' => 'Nacional Presencial',
            'rowClass' => 'bg-gray-50 text-center',
        ],
        [
            'label' => 'N° de asistentes Virtual (Internacional)',
            'key' => 'Internacional Virtual',
            'rowClass' => 'bg-gray-50 text-center',
        ],
        [
            'label' => 'N° de asistentes Virtual (Nacional)',
            'key' => 'Nacional Virtual',
            'rowClass' => 'bg-gray-50 text-center',
        ],
    ];
@endphp

<div class="col-span-2 col-start-1 row-span-1 self-start py-4 border-t mx-4 row-start-2 mt-4">
    <label for="chart-1" class="mb-4 font-semibold text-gray-500">
        Estadísticas de Asistentes por Período
    </label>
    <div class="relative w-full overflow-x-auto">
        <table class="min-w-full w-full divide-y divide-gray-200 rounded-lg overflow-hidden bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th scope="col"
                        class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                        Categoría
                    </th>
                    @foreach ($periods as $periodo)
                        <th scope="col"
                            class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider text-center">
                            {{ $periodo }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($rows as $row)
                    <tr class="{{ $row['rowClass'] }}">
                        <td class="px-4 py-4 whitespace-nowrap text-left text-sm text-gray-900">{{ $row['label'] }}</td>
                        @foreach ($periods as $periodo)
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $statistics[$row['key']][$periodo] ?? 0 }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class=" font-semibold bg-gray-50 text-center">
                    <td class="px-4 py-4 whitespace-nowrap text-left text-sm text-gray-900 font-semibold">Total</td>
                    @foreach ($periods as $periodo)
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $statistics['total'][$periodo] ?? 0 }}</td>
                    @endforeach
                </tr>
            </tfoot>
        </table>
    </div>
</div>
