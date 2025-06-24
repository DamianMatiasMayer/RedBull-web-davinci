
  document.addEventListener("DOMContentLoaded", () => {
    const botonFiltro = document.getElementById("boton-filtro");
    const contenedorFiltros = document.getElementById("filtros");
    const botonesCategoria = document.querySelectorAll(".filtro-categoria");
    const productos = document.querySelectorAll("[data-categoria]");
    const botonLimpiar = document.getElementById("limpiar-filtros");

    // Mostrar/Ocultar opciones de filtro
    botonFiltro.addEventListener("click", () => {
      contenedorFiltros.style.display =
        contenedorFiltros.style.display === "none" ? "flex" : "none";
    });

    // Aplicar filtros
    botonesCategoria.forEach((boton) => {
      boton.addEventListener("click", () => {
        const categoriaSeleccionada = boton.getAttribute("data-filtro");

        productos.forEach((producto) => {
          const categoria = producto.getAttribute("data-categoria");
          producto.style.display =
            categoria === categoriaSeleccionada ? "block" : "none";
        });
      });
    });

    // Limpiar filtros
    botonLimpiar.addEventListener("click", () => {
      productos.forEach((producto) => {
        producto.style.display = "block";
      });
    });
  });

