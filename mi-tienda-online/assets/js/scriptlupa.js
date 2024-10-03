// Obtener el botón de lupa y el formulario de búsqueda
const lupa = document.getElementById("lupa");
const searchForm = document.getElementById("search-form");
searchForm.style.display = "none";
// Agregar el evento de clic a la lupa
lupa.addEventListener("click", function () {
    // Verificar si el formulario de búsqueda está visible
    if (searchForm.style.display === "none" || searchForm.style.display === "") {
        // Si está oculto, mostrarlo
        searchForm.style.display = "block";
    } else {
        // Si está visible, ocultarlo
        searchForm.style.display = "none";
    }
});
