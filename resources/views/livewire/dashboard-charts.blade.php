<div>
    <br>
    <div class="grid grid-cols-3 grid-rows-[1fr_400px] gap-4 mt-4">
        <livewire:charts.assistances-bar-chart :statistics="$barChartStatistics" />
        <livewire:charts.mobility-pie-chart :statistics="$pieChartStatistics" />
        <livewire:charts.table-assistance-of-last-year-by-period :statistics="$tableByPeriodStatistics" :periods="$periodLabels" />
        <livewire:charts.table-total-activities :activities="$activitiesData" :totalResults="$totalResults" />
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
