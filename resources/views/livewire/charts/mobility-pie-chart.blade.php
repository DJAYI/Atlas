<div class="col-span-1 col-start-3 border-t row-span-1 mt-4 flex flex-col items-between">
    <label for="chart-1" class="my-8 font-semibold text-gray-500">
        Movilidades del Último Año
    </label>
    <div id="chart-1"></div>
</div>

<script>
    const mobilitiesSeries = Object.values(@json($statistics));

    const totalMobilities = mobilitiesSeries.reduce((total, value) => total + value, 0);


    const pieChartOptions = {
        chart: {
            type: 'donut',
            height: 'auto',
            toolbar: {
                show: true,
                tools: {
                    download: true,
                    selection: true,
                    zoom: true,
                    zoomin: true,
                    zoomout: true,
                    pan: true,
                }
            },
        },

        plotOptions: {
            pie: {
                donut: {
                    labels: {
                        show: true,
                        name: {
                            show: true,
                            fontSize: '22px',
                            fontFamily: 'Helvetica, Arial, sans-serif',
                            color: undefined,
                            offsetY: -10,
                            formatter: function(val) {
                                return val;
                            }
                        },
                        value: {
                            show: true,
                            fontSize: '16px',
                            fontFamily: 'Helvetica, Arial, sans-serif',
                            color: undefined,
                            offsetY: 10,
                            formatter: function(val) {
                                return val;
                            }
                        },
                        total: {
                            show: true,
                            label: 'Total',
                            fontSize: '22px',
                            fontFamily: 'Helvetica, Arial, sans-serif',
                            color: '#373d3f',
                            formatter: function(w) {
                                return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                            }
                        }
                    }
                }
            }
        },

        series: mobilitiesSeries,
        labels: ['Entrantes', 'Salientes', 'En Casa']
    }



    const pieChart = new ApexCharts(document.querySelector("#chart-1"), pieChartOptions);
    pieChart.render();
</script>
