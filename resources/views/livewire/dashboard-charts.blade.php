<div>
    <br>
    <div class="grid grid-cols-3 grid-rows-2 gap-4 mt-4" id="chart-container">
        <div class="col-span-2 row-span-2 border-r">
            <div class="flex flex-row justify-between pe-4 py-2 border-b">
                <label for="chart-0" class="text-xl font-semibold text-primary">
                    Estadísticas de Asistencias
                </label>
                <div class="flex flex-row gap-4 mb-2">
                    <select wire:model="movilitySelected" class="rounded-lg font-semibold" name="movility"
                        id="movility-select">
                        <option value="profesor">Docentes</option>
                        <option value="estudiante">Estudiantes</option>
                        <option value="egresado">Egresados</option>
                    </select>
                    <select wire:model="modalitySelected" class="rounded-lg font-semibold" name="modality"
                        id="modality-select">
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
    const renderCharts = (counts) => {
        console.log(counts);

        const years = Object.keys(counts);
        const outgoingNational = years.map(year => counts[year].outgoing_national);
        const incomingNational = years.map(year => counts[year].incoming_national);
        const outgoingInternational = years.map(year => counts[year].outgoing_international);
        const incomingInternational = years.map(year => counts[year].incoming_international);

        const options = {
            chart: {
                type: 'bar',
                group: 'Asistencias'
            },
            series: [{
                    name: 'Salientes Nacional',
                    data: outgoingNational,
                },
                {
                    name: 'Entrantes Nacional',
                    data: incomingNational,
                },
                {
                    name: 'Salientes Internacional',
                    data: outgoingInternational,
                },
                {
                    name: 'Entrantes Internacional',
                    data: incomingInternational,
                },
            ],
            xaxis: {
                categories: years,
            },
        };

        const chart = new ApexCharts(document.querySelector("#chart-0"), options);
        chart.render();
    };

    // Initial render
    renderCharts(@json($counts));
</script>
