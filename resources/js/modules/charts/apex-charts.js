import ApexCharts from "apexcharts";
const $ = (selector) => document.querySelector(selector);
const $$ = (selector) => document.querySelectorAll(selector);

let optionsArray = [
    {
        chart: {
            type: "bar",
        },
        series: [
            {
                name: "sales",
                data: [30, 40, 35, 50, 49, 60, 70, 91, 125],
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
        series: [
            {
                name: "revenue",
                data: [10, 20, 15, 25, 24, 30, 40, 50, 60],
            },
        ],
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
        series: [
            {
                name: "revenue",
                data: [10, 20, 15, 25, 24, 30, 40, 50, 60],
            },
        ],
        xaxis: {
            categories: [2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008],
        },
    },
];

optionsArray.forEach((options, index) => {
    let chart = new ApexCharts($(`#chart-${index}`), options);
    chart.render();
});
