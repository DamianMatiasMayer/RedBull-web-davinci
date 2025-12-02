document.addEventListener("DOMContentLoaded", () => {
  const filas = document.querySelectorAll(".fila-accesorios");
  const botonCargarMas = document.getElementById("cargar-mas");

  // Si en esta página no hay filas o no hay botón, no hacemos nada
  if (!filas.length || !botonCargarMas) return;

  let filasVisibles = 4; // por ejemplo, las primeras 4

  function actualizarVisibilidad() {
    filas.forEach((fila, index) => {
      if (index < filasVisibles) {
        fila.style.display = "flex";
        fila.classList.add("visible");
      } else {
        fila.style.display = "none";
        fila.classList.remove("visible");
      }
    });

    // Ocultar botón si ya no hay más para mostrar
    if (filasVisibles >= filas.length) {
      botonCargarMas.style.display = "none";
    } else {
      botonCargarMas.style.display = "block";
    }
  }

  // Inicial
  actualizarVisibilidad();

  // Evento click
  botonCargarMas.addEventListener("click", () => {
    filasVisibles += 4; // mostrar 4 filas más cada vez
    actualizarVisibilidad();
  });
});
