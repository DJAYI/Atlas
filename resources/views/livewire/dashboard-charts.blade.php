<div>
    <br>
    <div class="grid grid-cols-3 grid-rows-2 gap-4 mt-4" id="chart-container">
        <livewire:charts.assistances-bar-chart />
        <livewire:charts.mobility-pie-chart />
        <div class="col-span-1 row-span-1">
            <label for="chart-2" class="text-gray-500">
                Gráfica <span class="text-secondary-400">*</span>
            </label>
            <div id="chart-2"></div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
