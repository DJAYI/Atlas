<div class="">
    <h2 class="text-xl font-semibold text-primary">Resumen del Ultimo Año</h2>
    <div class="flex items-center justify-between mt-3 mb-5 gap-11">

        @foreach ([
        ['title' => 'N° Eventos', 'id' => 'spark-events', 'count' => $totalEvents],
        ['title' => 'N° Participantes', 'id' => 'spark-assistances', 'count' => $totalAssistances],
        ['title' => 'N° Programas Participantes', 'id' => 'spark-careers', 'count' => $totalCareers],
        [
            'title' => 'N° Participantes Únicos',
            'id' => 'spark-unique-participants',
            'count' => $totalUniqueParticipants,
        ],
    ] as $stat)
            <div class="grid w-full grid-cols-2 px-4 py-3 rounded-xl shadow-primary-400 bg-white shadow-2xl gap-12">
                <div>
                    <h2 class="text-2xl font-semibold text-primary-500">{{ $stat['title'] }}</h2>
                    <div class="flex mt-2">
                        <h2 class="text-4xl font-semibold text-primary-600">{{ $stat['count'] }}</h2>
                    </div>
                </div>
                <div class="w-full" id="{{ $stat['id'] }}"></div>
            </div>
        @endforeach
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    const sparkData = [{
            id: 'spark-events',
            name: 'Eventos',
            data: @json($lastYearEventsPerMonth['data']),
            labels: @json($lastYearEventsPerMonth['labels'])
        },
        {
            id: 'spark-assistances',
            name: 'Asistencias',
            data: @json($lastYearAssistancesPerMonth['data']),
            labels: @json($lastYearAssistancesPerMonth['labels'])
        },
        {
            id: 'spark-careers',
            name: 'Programas Participantes',
            data: @json($lastYearCareersPerMonth['data']),
            labels: @json($lastYearCareersPerMonth['labels'])
        },
        {
            id: 'spark-unique-participants',
            name: 'Participantes únicos',
            data: @json($lastYearUniqueParticipantsPerMonth['data']),
            labels: @json($lastYearUniqueParticipantsPerMonth['labels'])
        }
    ];

    sparkData.forEach(({
        id,
        name,
        data,
        labels
    }) => {
        const options = {
            chart: {
                id,
                type: 'area',
                height: 150,
                toolbar: {
                    show: true
                },
                sparkline: {
                    enabled: true
                },
                group: 'sparklines',

            },
            series: [{
                name,
                data
            }],
            stroke: {
                curve: 'smooth'
            },
            markers: {
                size: 0
            },
            tooltip: {
                enabled: true,
                x: {
                    show: true,
                    formatter: function(val, opts) {
                        if (labels && labels[opts.dataPointIndex]) {
                            return labels[opts.dataPointIndex];
                        }
                        return val;
                    }
                },
            },
            fill: {
                type: "gradient",
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.9,
                    stops: [0, 90, 100]
                }
            },
        };

        const chart = new ApexCharts(document.querySelector(`#${id}`), options);
        chart.render();
    });
</script>
