

document.addEventListener('DOMContentLoaded', () => {
  console.log('productos.js cargado');

  const tarjetas   = document.querySelectorAll('.card-producto');
  const modal      = document.getElementById('modal-producto');
  const btnClose   = document.getElementById('modal-producto-cerrar');
  const btnAgregar = document.getElementById('btn-agregar-modal');

  const img       = document.getElementById('modal-producto-img');
  const nombre    = document.getElementById('modal-producto-nombre');
  const categoria = document.getElementById('modal-producto-categoria');
  const desc      = document.getElementById('modal-producto-descripcion');
  const precio    = document.getElementById('modal-producto-precio');
  const stock     = document.getElementById('modal-producto-stock');
  const inputId   = document.getElementById('modal-producto-id');

  // Producto actualmente mostrado en el modal
  let productoActual = null;

function mostrarModal() {
  if (!modal) return;
  modal.classList.remove('oculto');   // solo muestro
}

function cerrarModalProducto() {
  if (!modal) return;
  modal.classList.add('oculto');      // solo oculto
}


  // Click en cada tarjeta de producto → abre modal
  if (tarjetas.length && modal) {
    tarjetas.forEach(card => {
      card.addEventListener('click', () => {
        console.log('Click en producto', card.dataset.id);

        const id     = card.dataset.id;
        const nom    = card.dataset.nombre;
        const cat    = card.dataset.categoria;
        const des    = card.dataset.descripcion;
        const preTxt = card.dataset.precio;           
        const imgSrc = card.dataset.img;
        const st     = parseInt(card.dataset.stock, 10);

        
        const precioNumero = parseFloat(
          preTxt.replace(/\./g, '').replace(',', '.')
        );

        const precioFormateado = '$' + precioNumero.toFixed(2);

        // Rellenar modal
        img.src = imgSrc;
        img.alt = nom;
        nombre.textContent    = nom;
        categoria.textContent = cat;
        desc.textContent      = des;
        precio.textContent    = precioFormateado;

        if (!isNaN(st)) {
          if (st > 0) {
            stock.textContent = 'Stock disponible: ' + st;
            stock.classList.remove('sin-stock');
          } else {
            stock.textContent = 'Sin stock';
            stock.classList.add('sin-stock');
          }
        } else {
          stock.textContent = '';
        }

        inputId.value = id;

        // Guardamos el producto actual para el carrito
        productoActual = {
          id: id,
          nombre: nom,
          precio: precioNumero,   // número
          imagen: imgSrc,
          cantidad: 1
        };

        mostrarModal();
      });
    });
  }

  // Cerrar con la X
  if (btnClose) {
    btnClose.addEventListener('click', cerrarModalProducto);
  }

  // Cerrar clickeando fuera del contenido
  if (modal) {
    modal.addEventListener('click', (e) => {
      // si cliqueo el “fondo” gris
      if (e.target === modal) cerrarModalProducto();
    });
  }

  // Cerrar con ESC
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') cerrarModalProducto();
  });

  // Botón "Agregar al carrito"
  if (btnAgregar) {
    btnAgregar.addEventListener('click', () => {
      if (!productoActual) return;

      if (typeof window.agregarProductoAlCarrito === 'function') {
        window.agregarProductoAlCarrito(productoActual);
      }

      cerrarModalProducto();

      // Opcional: abrir carrito automáticamente
      const carritoContainer = document.getElementById('carrito-container');
      if (carritoContainer && carritoContainer.classList.contains('oculto')) {
        carritoContainer.classList.remove('oculto');
        
        if (typeof window.actualizarVistaCarrito === 'function') {
          window.actualizarVistaCarrito();
        }
      }
    });
  }
});
