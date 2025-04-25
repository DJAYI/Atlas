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
            return index === 0 ? yearData.nacional.estudiante.presencial.entrantes :

                index === 1 ? yearData.internacional.estudiante.presencial
                .entrantes :

                index === 2 ? yearData.nacional.estudiante.presencial
                .salientes :

                index === 3 ? yearData.internacional.estudiante.presencial
                .salientes : 0;
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
