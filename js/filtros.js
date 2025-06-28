
const botonFiltro = document.getElementById("boton-filtro");
const contenedorFiltros = document.getElementById("filtros");
const botonesFiltro = document.querySelectorAll(".filtro-categoria");
const limpiarBtn = document.getElementById("limpiar-filtros");
const productos = document.querySelectorAll(".producto, .productos-accesorios");
const chips = document.getElementById("chips-activos");

let filtrosActivos = new Set();

botonFiltro.addEventListener("click", () => {
  contenedorFiltros.style.display =
    contenedorFiltros.style.display === "none" ? "flex" : "none";
});

botonesFiltro.forEach(boton => {
  boton.addEventListener("click", () => {
    const filtro = boton.dataset.filtro;
    if (filtrosActivos.has(filtro)) {
      filtrosActivos.delete(filtro);
    } else {
      filtrosActivos.add(filtro);
    }
    actualizarChips();
    aplicarFiltros();
  });
});

limpiarBtn.addEventListener("click", () => {
  filtrosActivos.clear();
  actualizarChips();
  aplicarFiltros();
});

function actualizarChips() {
  chips.innerHTML = "";
  filtrosActivos.forEach(filtro => {
    const chip = document.createElement("span");
    chip.className = "chip";
    chip.textContent = filtro.charAt(0).toUpperCase() + filtro.slice(1);

    const close = document.createElement("span");
    close.className = "close";
    close.textContent = "×";
    close.onclick = () => {
      filtrosActivos.delete(filtro);
      actualizarChips();
      aplicarFiltros();
    };

    chip.appendChild(close);
    chips.appendChild(chip);
  });
}

function aplicarFiltros() {
  const filas = document.querySelectorAll(".fila-accesorios");
  const botonCargarMas = document.getElementById("cargar-mas");

  if (filtrosActivos.size > 0) {
    // Mostrar todas las filas para aplicar filtro completo
    filas.forEach(fila => {
      fila.style.display = "flex";
      fila.classList.add("visible");
    });
    botonCargarMas.style.display = "none";
  } else {
    // Mostrar solo las primeras 4 filas (16 productos)
    filas.forEach((fila, index) => {
      if (index < 4) {
        fila.style.display = "flex";
        fila.classList.add("visible");
      } else {
        fila.style.display = "none";
        fila.classList.remove("visible");
      }
    });

    // Mostrar botón si quedan filas por mostrar
    if (filas.length > 4) {
      botonCargarMas.style.display = "block";
    } else {
      botonCargarMas.style.display = "none";
    }
  }

  // Mostrar u ocultar productos según los filtros activos
  productos.forEach(producto => {
    const categoria = producto.dataset.categoria;
    const mostrar = filtrosActivos.size === 0 || filtrosActivos.has(categoria);
    producto.style.display = mostrar ? "block" : "none";
  });
}
