<div class="col-span-2 col-start-1 row-span-2 row-start-1 border-r">
    <div class="flex flex-row justify-between py-2 border-b pe-4">
        <label for="chart-0" class="text-xl font-semibold text-primary">
            Estadísticas de Asistencias
        </label>
        <div class="flex flex-row gap-4 mb-2">
            <select wire:model="movility" class="font-semibold rounded-lg" name="movility" id="movility-select">
                <option value="profesor" selected>Docentes</option>
                <option value="estudiante">Estudiantes</option>
            </select>
            <select wire:model="modality" class="font-semibold rounded-lg" name="modality" id="modality-select">
                <option value="presencial" selected>Presencial</option>
                <option value="virtual">Virtual</option>
            </select>
        </div>
    </div>
    <div id="chart-0"></div>
</div>



<script>
    document.addEventListener('DOMContentLoaded', () => {
        const $ = selector => document.querySelector(selector);

        const movilitySelect = $('#movility-select');
        const modalitySelect = $('#modality-select');
        const chartContainer = $('#chart-0');
        const statistics = @json($statistics);

        const getSeries = (stats, mov, mod) => {
            const labels = [
                mov === 'profesor' ? 'Docentes Entrantes (Nacional)' :
                'Estudiantes Entrantes (Nacional)',
                mov === 'profesor' ? 'Docentes Entrantes (Internacional)' :
                'Estudiantes Entrantes (Internacional)',
                mov === 'profesor' ? 'Docentes Entrantes (Local)' : 'Estudiantes Entrantes (Local)',
                mov === 'profesor' ? 'Docentes Salientes (Nacional)' :
                'Estudiantes Salientes (Nacional)',
                mov === 'profesor' ? 'Docentes Salientes (Internacional)' :
                'Estudiantes Salientes (Internacional)',
                mov === 'profesor' ? 'Docentes Salientes (Local)' : 'Estudiantes Salientes (Local)',
            ];
            const data = Object.values(stats).map(year => [
                year.nacional[mov][mod].entrantes,
                year.internacional[mov][mod].entrantes,
                year.local[mov][mod].entrantes,
                year.nacional[mov][mod].salientes,
                year.internacional[mov][mod].salientes,
                year.local[mov][mod].salientes
            ]);
            return labels.map((name, i) => ({
                name,
                data: data.map(row => row[i])
            }));
        };

        const chartOptions = {
            chart: {
                type: 'bar',
                height: 850,
                toolbar: {
                    show: true
                },
                selection: {
                    enabled: true
                }
            },
            series: [],
            xaxis: {
                categories: Object.keys(statistics),
                title: {
                    text: 'Años'
                }
            },
            dataLabels: {
                enabled: true
            },
            position: 'bottom',
            horizontalAlign: 'center',
        };

        const chart = new ApexCharts(chartContainer, chartOptions);

        const updateChart = () => {
            chart.updateSeries(getSeries(statistics, movilitySelect.value, modalitySelect.value));
        };

        movilitySelect.addEventListener('change', updateChart);
        modalitySelect.addEventListener('change', updateChart);

        chart.render().then(updateChart);
    });
</script>
