<div class="col-span-2 col-start-1 row-span-2 row-start-1 border-r">
    <div class="flex flex-row justify-between py-2 border-b pe-4">
        <label for="chart-0" class="text-xl font-semibold text-primary">
            Estadísticas de Asistencias
        </label>
        <div class="flex flex-row gap-4 mb-2">
            <select class="font-semibold rounded-lg" name="movility" id="movility-select">
                <option value="estudiante">Estudiantes</option>
                <option value="profesor">Docentes</option>
                <option value="egresado">Egresados</option>
                <option value="empresario">Empresarios</option>
                <option value="administrativo">Administrativos</option>
            </select>
            <select class="font-semibold rounded-lg" name="modality" id="modality-select">
                <option value="presencial">Presencial</option>
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

        console.log("Datos recibidos en gráfico de barras:", statistics);

        // Análisis de los datos recibidos
        if (statistics) {
            const years = Object.keys(statistics);
            console.log("Años disponibles:", years);

            if (years.length > 0) {
                const firstYear = statistics[years[0]];
                // Comprobamos qué roles están disponibles
                const locations = Object.keys(firstYear);
                console.log("Ubicaciones disponibles:", locations);

                if (locations.includes('nacional')) {
                    const roles = Object.keys(firstYear['nacional']);
                    console.log("Roles disponibles:", roles);

                    // Si hay roles disponibles, establecemos el primero como valor inicial
                    if (roles.length > 0 && movilitySelect.value !== roles[0]) {
                        console.log("Estableciendo rol inicial:", roles[0]);
                    }
                }
            }
        }

        // Verificamos si hay datos antes de continuar
        if (!statistics || Object.keys(statistics).length === 0) {
            console.error("No se recibieron datos para el gráfico de barras");

            // Mostramos un mensaje en el gráfico
            const errorDiv = document.createElement('div');
            errorDiv.className = 'text-center text-red-500 py-8';
            errorDiv.innerHTML = 'No hay datos disponibles para mostrar';
            chartContainer.appendChild(errorDiv);
            return;
        }

        const getSeries = (stats, mov, mod) => {
            console.log(`Generando series para: ${mov} - ${mod}`);

            const labels = [
                `${capitalize(mov)}s Entrantes (Nacional)`,
                `${capitalize(mov)}s Entrantes (Internacional)`,
                `${capitalize(mov)}s Entrantes (Local)`,
                `${capitalize(mov)}s Salientes (Nacional)`,
                `${capitalize(mov)}s Salientes (Internacional)`,
                `${capitalize(mov)}s Salientes (Local)`
            ];

            const data = Object.values(stats).map(year => {
                console.log(`Procesando año:`, year);

                // Debug para ver qué roles existen en el objeto
                if (year.nacional) {
                    console.log(`Roles disponibles en nacional:`, Object.keys(year.nacional));
                }

                // Validación de seguridad para evitar errores si alguna propiedad no existe
                const nacional = year.nacional && year.nacional[mov] && year.nacional[mov][mod] ?
                    year.nacional[mov][mod] : {
                        entrantes: 0,
                        salientes: 0
                    };

                const internacional = year.internacional && year.internacional[mov] && year
                    .internacional[mov][mod] ?
                    year.internacional[mov][mod] : {
                        entrantes: 0,
                        salientes: 0
                    };

                const local = year.local && year.local[mov] && year.local[mov][mod] ?
                    year.local[mov][mod] : {
                        entrantes: 0,
                        salientes: 0
                    };

                return [
                    nacional.entrantes || 0,
                    internacional.entrantes || 0,
                    local.entrantes || 0,
                    nacional.salientes || 0,
                    internacional.salientes || 0,
                    local.salientes || 0
                ];
            });
            return labels.map((name, i) => ({
                name,
                data: data.map(row => row[i])
            }));
        };

        function capitalize(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }

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
            try {
                const series = getSeries(statistics, movilitySelect.value, modalitySelect.value);
                console.log("Series generadas:", series);
                chart.updateSeries(series);
            } catch (error) {
                console.error("Error al actualizar el gráfico:", error);
            }
        };

        // Escuchar cambios directos en los selectores (para navegadores que no soporten Livewire)
        movilitySelect.addEventListener('change', updateChart);
        modalitySelect.addEventListener('change', updateChart);

        // Escuchar eventos de Livewire
        window.addEventListener('update-chart', (event) => {
            console.log('Evento de Livewire recibido:', event.detail);

            // Actualizar los selectores con los valores recibidos
            if (event.detail.movility) {
                movilitySelect.value = event.detail.movility;
            }

            if (event.detail.modality) {
                modalitySelect.value = event.detail.modality;
            }

            updateChart();
        });

        chart.render().then(updateChart);
    });
</script>
