const $ = (selector) => document.querySelector(selector);
const $$ = (selector) => document.querySelectorAll(selector);

let startDate;
let endDate;

// Verificar que la fecha final no sea menor a la fecha inicial
$("#end_date").addEventListener("change", (e) => {
    startDate = new Date($("#start_date").value);
    endDate = new Date(e.target.value);

    if (endDate < startDate) {
        alert("La fecha de fin no puede ser menor a la fecha de inicio");
        e.target.value = "";
    }
});
$("#start_date").addEventListener("change", (e) => {
    startDate = new Date(e.target.value);
    endDate = new Date($("#end_date").value);

    if (endDate < startDate) {
        alert("La fecha de fin no puede ser menor a la fecha de inicio");
        $("#end_date").value = "";
    }
});
