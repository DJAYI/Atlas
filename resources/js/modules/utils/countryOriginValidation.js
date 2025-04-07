const $ = (selector) => document.querySelector(selector);
const $$ = (selector) => document.querySelectorAll(selector);

const countryOrigin = $("#country_of_origin");
const identityDocumentFile = $("#identity_document");

countryOrigin.addEventListener("change", (e) => {
    const selectedValue = e.target.value;

    // Si el país no es Colombia, se muestra el campo de archivo de documento de identidad con un display flex
    if (selectedValue !== "1") {
        identityDocumentFile.parentElement.classList.remove("hidden");
        identityDocumentFile.parentElement.classList.add("flex");
        identityDocumentFile.setAttribute("required", "required"); // Hacer que el campo sea requerido
    } else {
        identityDocumentFile.parentElement.classList.add("hidden");
        identityDocumentFile.parentElement.classList.remove("flex");
        identityDocumentFile.removeAttribute("required"); // Hacer que el campo no sea requerido
    }
});

if (countryOrigin.value !== "1") {
    identityDocumentFile.parentElement.classList.remove("hidden");
    identityDocumentFile.parentElement.classList.add("flex");
    identityDocumentFile.setAttribute("required", "required"); // Hacer que el campo sea requerido
} else {
    identityDocumentFile.parentElement.classList.add("hidden");
    identityDocumentFile.parentElement.classList.remove("flex");
    identityDocumentFile.removeAttribute("required"); // Hacer que el campo no sea requerido
}
