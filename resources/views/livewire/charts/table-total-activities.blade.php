<div class="col-span-1 row-span-1 col-start-3 row-start-1 py-4 max-h-[900px] overflow-y-auto">
    <label for="chart-1" class="mb-4 font-semibold text-gray-500">
        Actividades realizadas
    </label>
    <table class="divide-y divide-gray-200 rounded-lg overflow-hidden bg-white">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Tipo de
                    Actividad</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Total
                    Asistentes</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Total
                    Actividades</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($activities as $activity)
                <tr class="text-center">
                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ $activity['name'] }}</td>
                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ $activity['total_assistants'] }}
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ $activity['total_activities'] }}
                    </td>
                </tr>
            @endforeach

            <tr class="text-center font-semibold bg-gray-50">
                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold">Total</td>
                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ $totalResults['total_assistants'] }}
                </td>
                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ $totalResults['total_activities'] }}
                </td>
            </tr>
        </tbody>
    </table>
</div>
