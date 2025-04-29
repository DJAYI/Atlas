<div class="col-span-1 row-span-1">
    <label for="chart-1" class="text-gray-500 font-semibold">
        Movilidades del Ultimo Año
    </label>
    <div id="chart-1"></div>
</div>

<script>
    const mobilitiesSeries = Object.values(@json($statistics));
    const pieChartOptions = {
        chart: {
            type: 'pie',
            height: 350
        },
        series: mobilitiesSeries,
        labels: ['Entrantes', 'Salientes', 'En Casa']
    }

    const pieChart = new ApexCharts(document.querySelector("#chart-1"), pieChartOptions);
    pieChart.render();
</script>
