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


<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

@push('scripts')
    <script>
        let movility = @json($movility);
        let modality = @json($modality);
        let statistics = @json($statistics);


        const updateChart = () => {
            const labels = [
                movility === 'estudiante' ? "Estudiantes Entrantes (Nacional)" :
                "Profesores Entrantes (Nacional)",
                movility === 'estudiante' ? "Estudiantes Entrantes (Internacional)" :
                "Profesores Entrantes (Internacional)",
                movility === 'estudiante' ? "Estudiantes Salientes (Nacional)" :
                "Profesores Salientes (Nacional)",
                movility === 'estudiante' ? "Estudiantes Salientes (Internacional)" :
                "Profesores Salientes (Internacional)",
                movility === 'estudiante' ? "Estudiantes Entrantes (Local)" :
                "Profesores Entrantes (Local)",
                movility === 'estudiante' ? "Estudiantes Salientes (Local)" :
                "Profesores Salientes (Local)"
            ];

            const series = labels.map((name, index) => {
                const region = ['nacional', 'internacional', 'nacional', 'internacional', 'local', 'local'][
                    index
                ];
                const direction = ['entrantes', 'entrantes', 'salientes', 'salientes', 'entrantes', 'salientes']
                    [index];


                const data = Object.keys(statistics).map(year => {
                    return (((statistics[year] || {})[region] || {})[movility] || {})[
                        modality]?.[direction] || 0; // Added default value of 0
                });


                return {
                    name,
                    data
                };
            });

            const options = {
                chart: {
                    type: 'bar',
                    stacked: false
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        borderRadius: 5 // Added border radius for bars
                    }
                },
                dataLabels: {
                    enabled: true
                },
                xaxis: {
                    categories: Object.keys(statistics),
                    title: {
                        text: 'Años' // Added title for x-axis
                    }
                },
                series
            };

            const chartElement = document.querySelector("#chart-0");
            if (chartElement) {
                chartElement.innerHTML = "";
                new ApexCharts(chartElement, options).render();
            }
        };

        Livewire.on('statisticsUpdated', (payload) => {
            movility = payload.movility;
            modality = payload.modality;
            updateChart();
        });

        document.getElementById('modality-select').addEventListener('change', (event) => {
            modality = event.target.value;
            updateChart();
        });

        document.getElementById('movility-select').addEventListener('change', (event) => {
            movility = event.target.value;
            updateChart();
        });

        updateChart();
    </script>
@endpush
