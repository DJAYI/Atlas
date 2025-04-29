<div class="col-span-2 row-span-2 border-r">
    <div class="flex flex-row justify-between pe-4 py-2 border-b">
        <label for="chart-0" class="text-xl font-semibold text-primary">
            Estadísticas de Asistencias
        </label>
        <div class="flex flex-row gap-4 mb-2">
            <select wire:model="movility" class="rounded-lg font-semibold" name="movility" id="movility-select">
                <option value="profesor" selected>Docentes</option>
                <option value="estudiante">Estudiantes</option>
            </select>
            <select wire:model="modality" class="rounded-lg font-semibold" name="modality" id="modality-select">
                <option value="presencial" selected>Presencial</option>
                <option value="virtual">Virtual</option>
            </select>
        </div>
    </div>
    <div id="chart-0"></div>
</div>



<script>
    console.log(@json($statistics));

    const chartColumnOptions = {
        chart: {
            type: 'bar',
            height: 350,
            toolbar: {
                show: false
            }
        },
        series: [{
                name: 'Estudiantes Entrantes (Nacional)',
                data: [1, 2, 3]
            },
            {
                name: 'Estudiantes Entrantes (Internacional)',
                data: [1, 2, 3]
            },
            {
                name: 'Estudiantes Entrantes (Local)',
                data: [1, 2, 3]
            },
            {
                name: 'Estudiantes Salientes (Nacional)',
                data: [1, 2, 3]
            },
            {
                name: 'Estudiantes Salientes (Internacional)',
                data: [1, 2, 3]
            },
            {
                name: 'Estudiantes Salientes (Local)',
                data: [3, 2, 1]
            }
        ],
        xaxis: {
            categories: [2023, 2024, 2025],
            title: {
                text: 'Años'
            }
        },
        dataLabels: {
            enabled: true
        },
        position: 'bottom',
        horizontalAlign: 'center',

    }


    const chartColumn = new ApexCharts(document.querySelector("#chart-0"), chartColumnOptions);
    chartColumn.render();
</script>
