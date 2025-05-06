<div class="col-span-2 col-start-1 row-span-1 row-start-1 border-r">
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
    console.log(@json($statistics));

    const $ = (selector) => document.querySelector(selector);
    const $$ = (selector) => document.querySelectorAll(selector);

    const movilitySelect = $('#movility-select');
    const modalitySelect = $('#modality-select');

    const chartContainer = $('#chart-0');

    const statistics = @json($statistics);

    const getStatisticsSeries = (statistics, movility, modality) => {
        let series = [];

        let names = [
            movility == 'profesor' ? 'Docentes Entrantes (Nacional)' : 'Estudiantes Entrantes (Nacional)',
            movility == 'profesor' ? 'Docentes Entrantes (Internacional)' :
            'Estudiantes Entrantes (Internacional)',
            movility == 'profesor' ? 'Docentes Entrantes (Local)' : 'Estudiantes Entrantes (Local)',
            movility == 'profesor' ? 'Docentes Salientes (Nacional)' : 'Estudiantes Salientes (Nacional)',
            movility == 'profesor' ? 'Docentes Salientes (Internacional)' :
            'Estudiantes Salientes (Internacional)',
            movility == 'profesor' ? 'Docentes Salientes (Local)' : 'Estudiantes Salientes (Local)',
        ]

        let data = Object.values(statistics).map((years) => {
            return [
                years['nacional'][movility][modality]['entrantes'],
                years['internacional'][movility][modality]['entrantes'],
                years['local'][movility][modality]['entrantes'],
                years['nacional'][movility][modality]['salientes'],
                years['internacional'][movility][modality]['salientes'],
                years['local'][movility][modality]['salientes']
            ]
        });

        return names.map((name, index) => {
            return {
                name: name,
                data: data.map((locality) => {
                    return locality[index]
                })
            }
        });
    }

    const chartColumnOptions = {
        chart: {
            type: 'bar',
            height: 550,
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

    }

    const chartColumn = new ApexCharts(chartContainer, chartColumnOptions);

    const updateChartSeries = () => {
        const series = getStatisticsSeries(statistics, movilitySelect.value, modalitySelect.value);
        chartColumn.updateSeries(series);

    }

    movilitySelect.addEventListener('change', updateChartSeries);
    modalitySelect.addEventListener('change', updateChartSeries);

    chartColumn.render();
    updateChartSeries();
</script>
