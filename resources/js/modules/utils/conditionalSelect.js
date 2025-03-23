// Este script se encarga de mostrar u ocultar campos en función de la selección de otros campos en un formulario.
// Se utiliza para mostrar u ocultar campos de internacionalización en casa y convenios en función de la modalidad y si tiene convenio o no.

const $ = (selector) => document.querySelector(selector);
const $$ = (selector) => document.querySelectorAll(selector);

const selectModality = $("#modality");
const selectHasAgreement = $("#has_agreement");

selectModality.addEventListener("change", (e) => {
    const selectedValue = e.target.value;

    // Solo si es presencial, se muestra el campo de internacionalización en casa con un display flex
    if (selectedValue === "presencial") {
        $("#at_home").classList.remove("hidden");
        $("#at_home").classList.add("flex");
        $("#internationalization_at_home").value = "no"; // Resetear el valor del select

        $("#internationalization_at_home").setAttribute("required", "required");
    } else {
        $("#at_home").classList.add("hidden");
        $("#at_home").classList.remove("flex");
        $("#internationalization_at_home").removeAttribute("required");
        $("#internationalization_at_home").value = "no"; // Resetear el valor del select
    }
});

selectHasAgreement.addEventListener("change", (e) => {
    const selectedValue = e.target.value;

    // Si tiene convenio, se muestra el campo de convenios con un display flex
    if (selectedValue === "si") {
        $("#agreement_id").parentElement.classList.remove("hidden");
        $("#agreement_id").parentElement.classList.add("flex");

        // Poner como requerido el select de convenio
        $("#agreement_id").setAttribute("required", "required");
    } else {
        $("#agreement_id").parentElement.classList.add("hidden");
        $("#agreement_id").parentElement.classList.remove("flex");
        $("#agreement_id").removeAttribute("required");
    }
});
