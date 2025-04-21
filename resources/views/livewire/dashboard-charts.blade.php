<div class="">

    <div class="grid grid-cols-3 grid-rows-2 gap-4 mt-4" id="chart-container">
        <div class="col-span-2 row-span-2 border-r">
            <label for="chart-0" class="text-xl font-semibold text-primary">
                Estadisticas de Asistencias
            </label>
            <div id="chart-0"></div>
        </div>
        <div class="col-span-1 row-span-1">
            <label for="chart-1" class="text-gray-500">
                Grafica <span class="text-secondary-400">*</span>
            </label>
            <div id="chart-1"></div>
        </div>
        <div class="col-span-1 row-span-1">
            <label for="chart-2" class="text-gray-500">
                Grafica <span class="text-secondary-400">*</span>
            </label>
            <div id="chart-2"></div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    const $ = (selector) => document.querySelector(selector);
    const $$ = (selector) => document.querySelectorAll(selector);

    let optionsArray = [{
            chart: {
                type: "bar",
            },
            series: [{
                    name: "sales",
                    data: [30, 40, 35, 50, 49, 60, 70, 91, 125],
                    group: "lastYear",
                },
                {
                    name: "sales",
                    data: [20, 30, 25, 40, 44, 55, 60, 70, 80],
                    group: "thisYear",
                }, {
                    name: "sales",
                    data: [30, 40, 35, 50, 49, 60, 70, 91, 125],
                    group: "lastYear",
                },
            ],
            xaxis: {
                categories: [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998, 1999],
            },
        },
        {
            chart: {
                type: "line",
            },
            series: [{
                name: "revenue",
                data: [10, 20, 15, 25, 24, 30, 40, 50, 60],
            }, ],
            xaxis: {
                categories: [2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008],
            },
        },
        {
            chart: {
                type: "bar",
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                },
            },
            series: [{
                name: "revenue",
                data: [10, 20, 15, 25, 24, 30, 40, 50, 60],
            }, ],
            xaxis: {
                categories: [2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008],
            },
        },
    ];

    optionsArray.forEach((options, index) => {
        let chart = new ApexCharts($(`#chart-${index}`), options);
        chart.render();
    });
</script>
