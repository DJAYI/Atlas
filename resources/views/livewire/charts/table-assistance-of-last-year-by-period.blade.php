<div class="mb-10 mt-8">
    <h1 class="text-xl font-semibold text-primary my-4">Estadísticas de Asistentes por Período</h1>
    <div class="relative w-full overflow-x-auto  sm:rounded-lg">
        <table class=" text-sm text-left text-gray-500 rtl:text-right">
            <thead class="text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Categoría
                    </th>
                    <th scope="col" class="px-6 py-3 text-center bg-blue-500 text-white">
                        2023-1
                    </th>
                    <th scope="col" class="px-6 py-3 text-center bg-blue-500 text-white">
                        2023-2
                    </th>
                    <th scope="col" class="px-6 py-3 text-center bg-blue-500 text-white">
                        2024-1
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        N° de asistences Entrante (Internacional)
                    </td>
                    <td class="px-6 py-4 text-center">22</td>
                    <td class="px-6 py-4 text-center">0</td>
                    <td class="px-6 py-4 text-center">45</td>
                </tr>
                <tr class="bg-gray-50 border-b hover:bg-gray-100">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        N° de asistences Entrante (Nacional)
                    </td>
                    <td class="px-6 py-4 text-center">80</td>
                    <td class="px-6 py-4 text-center">1</td>
                    <td class="px-6 py-4 text-center">14</td>
                </tr>
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        N° de asistences Entrante Virtual (Internacional)
                    </td>
                    <td class="px-6 py-4 text-center">8</td>
                    <td class="px-6 py-4 text-center">38</td>
                    <td class="px-6 py-4 text-center">186</td>
                </tr>
                <tr class="bg-gray-50 border-b hover:bg-gray-100">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        N° de asistences Entrante Virtual (Nacional)
                    </td>
                    <td class="px-6 py-4 text-center">110</td>
                    <td class="px-6 py-4 text-center">22</td>
                    <td class="px-6 py-4 text-center">169</td>
                </tr>
            </tbody>
            <tfoot>
                <tr class="font-semibold text-gray-900 bg-gray-100">
                    <th scope="row" class="px-6 py-3 text-base">
                        Total
                    </th>
                    <td class="px-6 py-3 text-center">220</td>
                    <td class="px-6 py-3 text-center">61</td>
                    <td class="px-6 py-3 text-center">414</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<script>
    console.log(@json($statistics));
</script>
