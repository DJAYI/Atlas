document.addEventListener("DOMContentLoaded", function () {
    const mySelect = document.getElementById("university");

    // Inicializar Choices.js para permitir multi select
    new Choices(mySelect, {
        removeItemButton: true, // Mostrar un botón para eliminar opciones seleccionadas
        delimiter: ",", // Usar coma como delimitador de valores seleccionados (esto es solo para visualización)
        maxItemCount: 5, // Limitar el número de elementos seleccionables (opcional)
        searchEnabled: true, // Desactivar la búsqueda (opcional)
    });
});
