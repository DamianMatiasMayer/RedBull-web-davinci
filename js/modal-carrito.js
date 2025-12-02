// js/modal-carrito.js

let carrito = [];

// =======================
//  Utilidades de storage
// =======================
function guardarCarrito() {
  try {
    localStorage.setItem('carritoRedBull', JSON.stringify(carrito));
  } catch (e) {
    console.warn('No se pudo guardar el carrito en localStorage', e);
  }
}

function cargarCarrito() {
  try {
    const data = localStorage.getItem('carritoRedBull');
    if (data) {
      carrito = JSON.parse(data);
    }
  } catch (e) {
    console.warn('No se pudo leer el carrito de localStorage', e);
    carrito = [];
  }
}

// =======================
//  Render del carrito
// =======================
function formatearPrecio(valor) {
  // valor es número
  return '$' + valor.toFixed(2);
}

function actualizarVistaCarrito() {
  const lista          = document.getElementById('lista-carrito');
  const totalElem      = document.getElementById('total-carrito');
  const vacio          = document.getElementById('carrito-vacio');
  const botonFinalizar = document.getElementById('boton-finalizar');

  if (!lista || !totalElem || !vacio) return;

  lista.innerHTML = '';
  let total = 0;

  if (!carrito.length) {
    vacio.classList.remove('oculto');
    totalElem.textContent = '';
    if (botonFinalizar) botonFinalizar.classList.add('oculto');
    return;
  }

  vacio.classList.add('oculto');
  if (botonFinalizar) botonFinalizar.classList.remove('oculto');

  carrito.forEach((prod, idx) => {
    const li = document.createElement('li');
    li.innerHTML = `
      <img src="${prod.imagen}" alt="${prod.nombre}">
      <div>
        <p>${prod.nombre}</p>
        <p>${formatearPrecio(prod.precio)}</p>
        <div class="cantidad-control">
          <button type="button" data-accion="restar" data-index="${idx}">-</button>
          <span>${prod.cantidad}</span>
          <button type="button" data-accion="sumar" data-index="${idx}">+</button>
        </div>
      </div>
      <button type="button" data-accion="eliminar" data-index="${idx}">
        <img src="imagenes/tacho.png" class="icono-tacho" alt="Eliminar">
      </button>
    `;
    lista.appendChild(li);

    total += prod.precio * prod.cantidad;
  });

  totalElem.textContent = 'Total: ' + formatearPrecio(total);
  actualizarContadorCarrito();
}

// =======================
//  Contador en el icono
// =======================
function actualizarContadorCarrito() {
  const contador = document.getElementById('contador-carrito');
  if (!contador) return;

  const cantidad = carrito.reduce((acc, prod) => acc + prod.cantidad, 0);

  if (cantidad > 0) {
    contador.textContent = cantidad;
    contador.classList.remove('oculto');
  } else {
    contador.classList.add('oculto');
  }
}

// =======================
//  API pública (lo que usa productos.js)
// =======================
function agregarProductoAlCarrito(producto) {
  // producto: {id, nombre, precio (number), imagen, cantidad}
  const idx = carrito.findIndex(p => String(p.id) === String(producto.id));

  if (idx !== -1) {
    carrito[idx].cantidad += producto.cantidad || 1;
  } else {
    carrito.push({
      id: String(producto.id),
      nombre: producto.nombre,
      precio: Number(producto.precio),
      imagen: producto.imagen,
      cantidad: producto.cantidad || 1
    });
  }

  guardarCarrito();
  actualizarVistaCarrito();
}

// Para que productos.js la pueda usar
window.agregarProductoAlCarrito = agregarProductoAlCarrito;
window.actualizarVistaCarrito   = actualizarVistaCarrito;

// =======================
//  Acciones del carrito
// =======================
function cambiarCantidad(index, delta) {
  if (index < 0 || index >= carrito.length) return;
  carrito[index].cantidad += delta;
  if (carrito[index].cantidad <= 0) {
    carrito.splice(index, 1);
  }
  guardarCarrito();
  actualizarVistaCarrito();
}

function eliminarDelCarrito(index) {
  if (index < 0 || index >= carrito.length) return;
  carrito.splice(index, 1);
  guardarCarrito();
  actualizarVistaCarrito();
}

// Finalizar compra
function finalizarCompra() {
  carrito = [];
  guardarCarrito();
  actualizarVistaCarrito();
  actualizarContadorCarrito();

  const modalCompra = document.getElementById('mensaje-compra');
  if (modalCompra) modalCompra.classList.remove('oculto');
}

function cerrarMensajeCompra() {
  const modalCompra = document.getElementById('mensaje-compra');
  if (modalCompra) modalCompra.classList.add('oculto');
}

// Toggle carrito lateral
function toggleCarrito(event) {
  if (event) event.preventDefault();
  const carritoContainer = document.getElementById('carrito-container');
  if (!carritoContainer) return;

  if (carritoContainer.classList.contains('oculto')) {
    carritoContainer.classList.remove('oculto');
    actualizarVistaCarrito();
  } else {
    carritoContainer.classList.add('oculto');
  }
}

// Cerrar carrito clickeando fuera
document.addEventListener('mousedown', (event) => {
  const carritoContainer = document.getElementById('carrito-container');
  const iconoCarrito    = document.querySelector('.carrito-link');

  if (!carritoContainer || carritoContainer.classList.contains('oculto')) return;

  const clicFuera =
    !carritoContainer.contains(event.target) &&
    (!iconoCarrito || !iconoCarrito.contains(event.target));

  if (clicFuera) {
    carritoContainer.classList.add('oculto');
  }
});

// Delegación de eventos para +, -, eliminar
document.addEventListener('click', (e) => {
  const btn = e.target.closest('button[data-accion]');
  if (!btn) return;

  const accion = btn.dataset.accion;
  const index  = parseInt(btn.dataset.index, 10);

  if (Number.isNaN(index)) return;

  if (accion === 'sumar') {
    cambiarCantidad(index, 1);
  } else if (accion === 'restar') {
    cambiarCantidad(index, -1);
  } else if (accion === 'eliminar') {
    eliminarDelCarrito(index);
  }
});

// =======================
//  Inicialización
// =======================
document.addEventListener('DOMContentLoaded', () => {
  cargarCarrito();
  actualizarVistaCarrito();
  actualizarContadorCarrito();
});

// Exponemos algunas funciones globales que ya usa tu HTML
window.toggleCarrito        = toggleCarrito;
window.finalizarCompra      = finalizarCompra;
window.cerrarMensajeCompra  = cerrarMensajeCompra;
