<div class="">

    <div class="grid grid-cols-3 grid-rows-2 gap-4 mt-4" id="chart-container">
        <div class="col-span-2 row-span-2 border-r">
            <label for="chart-0" class="text-xl font-semibold text-gray-500">
                Gráfica de Barras
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


@vite('resources/js/modules/charts/apex-charts.js')
