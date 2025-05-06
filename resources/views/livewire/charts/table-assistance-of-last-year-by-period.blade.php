@php
    $rows = [
        [
            'label' => 'N° de asistentes (Internacional)',
            'key' => 'Internacional Presencial',
            'rowClass' => 'bg-white border-b hover:bg-gray-50',
        ],
        [
            'label' => 'N° de asistentes (Nacional)',
            'key' => 'Nacional Presencial',
            'rowClass' => 'border-b bg-gray-50 hover:bg-gray-100',
        ],
        [
            'label' => 'N° de asistentes Virtual (Internacional)',
            'key' => 'Internacional Virtual',
            'rowClass' => 'bg-white border-b hover:bg-gray-50',
        ],
        [
            'label' => 'N° de asistentes Virtual (Nacional)',
            'key' => 'Nacional Virtual',
            'rowClass' => 'border-b bg-gray-50 hover:bg-gray-100',
        ],
    ];
@endphp


<div class="mt-8 mb-10">
    <h1 class="my-4 text-xl font-semibold text-primary">Estadísticas de Asistentes por Período</h1>
    <div class="relative w-full overflow-x-auto sm:rounded-lg">
        <table class="text-sm text-left text-gray-500 rtl:text-right">
            <thead class="text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-lg">
                        Categoría
                    </th>
                    @foreach ($statistics['periodos'] as $periodo)
                        <th scope="col" class="px-6 py-3 text-lg text-center text-white bg-blue-500">
                            {{ $periodo }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($rows as $row)
                    <tr class="{{ $row['rowClass'] }}">
                        <td class="px-6 py-4 text-lg font-medium text-gray-900 whitespace-nowrap">
                            {{ $row['label'] }}
                        </td>
                        @foreach ($statistics['data'][$row['key']] as $count)
                            <td class="px-6 py-4 text-center">{{ $count }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-semibold text-gray-900 bg-gray-100">
                    <th scope="row" class="px-6 py-3 text-base">
                        Total
                    </th>
                    @foreach ($statistics['data']['total'] as $count)
                        <td class="px-6 py-4 text-center">{{ $count }}</td>
                    @endforeach
                </tr>
            </tfoot>
        </table>
    </div>
</div>
