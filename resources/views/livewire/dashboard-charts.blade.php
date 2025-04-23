<div>
    <br>
    <div class="grid grid-cols-3 grid-rows-2 gap-4 mt-4" id="chart-container">
        <div class="col-span-2 row-span-2 border-r">
            <div class="flex flex-row justify-between pe-4 py-2 border-b">
                <label for="chart-0" class="text-xl font-semibold text-primary">
                    Estadísticas de Asistencias
                </label>
                <div class="flex flex-row gap-4 mb-2">
                    <select class="rounded-lg font-semibold" name="movility" id="movility-select">
                        <option value="profesor">Docentes</option>
                        <option value="estudiante">Estudiantes</option>
                        <option value="egresado">Egresados</option>
                    </select>
                    <select class="rounded-lg font-semibold" name="modality" id="modality-select">
                        <option value="virtual">Virtual</option>
                        <option value="presencial">Presencial</option>
                    </select>
                </div>
            </div>
            <div id="chart-0"></div>
        </div>
        <div class="col-span-1 row-span-1">
            <label for="chart-1" class="text-gray-500">
                Gráfica <span class="text-secondary-400">*</span>
            </label>
            <div id="chart-1"></div>
        </div>
        <div class="col-span-1 row-span-1">
            <label for="chart-2" class="text-gray-500">
                Gráfica <span class="text-secondary-400">*</span>
            </label>
            <div id="chart-2"></div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    const statistics = @json($statistics);
    console.log(statistics);

    const years = Object.keys(statistics);
    console.log(years);

    const nameSeries = [
        "N° de Estudiantes Entrante (Nacional)", // presencial → nacional
        "N° de Estudiantes Entrante (Internacional)", // presencial → internacional
        "N° de Estudiantes Saliente (Nacional)", // presencial → nacional
        "N° de Estudiantes Saliente (Internacional)", // presencial → internacional
    ];

    // Prepare series data
    const series = nameSeries.map((name, index) => {
        const data = years.map(year => {
            const yearData = statistics[year];
            if (index === 0) {
                return yearData.nacional.estudiantes.presencial.entrantes;
            } else if (index === 1) {
                return yearData.internacional.estudiantes.presencial.entrantes;
            } else if (index === 2) {
                return yearData.nacional.estudiantes.presencial.salientes;
            } else if (index === 3) {
                return yearData.internacional.estudiantes.presencial.salientes;
            }
            return 0;
        });
        return {
            name,
            data
        };
    });

    console.log(series);

    const options = {
        chart: {
            type: 'bar',
            stacked: false,
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
            },
        },
        dataLabels: {
            enabled: true,
        },
        xaxis: {
            categories: years,
        },
        series: series,
    };

    const chart = new ApexCharts(document.querySelector("#chart-0"), options);
    chart.render();
</script>
