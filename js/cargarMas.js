document.addEventListener("DOMContentLoaded", () => {
  const filas = document.querySelectorAll(".fila-accesorios");
  const botonCargarMas = document.getElementById("cargar-mas");
  let visibles = 4; // 4 filas (16 productos) visibles inicialmente

  function actualizarVisibilidad() {
    filas.forEach((fila, index) => {
      fila.style.display = index < visibles ? "flex" : "none";
    });

    // Ocultar el botón si ya no hay más filas por mostrar
    if (visibles >= filas.length) {
      botonCargarMas.style.display = "none";
    }
  }

  // Mostrar filas iniciales
  actualizarVisibilidad();

  // Al hacer clic, mostrar 4 filas más (16 productos)
  botonCargarMas.addEventListener("click", () => {
    visibles += 4;
    actualizarVisibilidad();
  });
});
