let carrito = [];           // Guarda los productos añadidos al carrito
let productoActual = null;  // Producto que se muestra en el modal actualmente

// Cuando la página se carga
document.addEventListener("DOMContentLoaded", () => {
    const productos = document.querySelectorAll(".producto, .productos-accesorios");

    productos.forEach(prod => {
        const imagen = prod.querySelector("img");
        if (imagen) {
            imagen.addEventListener("click", (e) => {
                e.stopPropagation(); // evita que el clic se propague
                mostrarDetalleProducto(prod);
            });
        }
    });

    cargarCarrito();              // Carga productos del carrito guardado en localStorage
    actualizarContadorCarrito(); // Actualiza el número del ícono del carrito
});

// Mostrar detalle del producto en el modal
function mostrarDetalleProducto(producto) {
    const id = producto.dataset.id;
    const nombre = producto.querySelector("p").textContent;
    const precio = producto.querySelector(".precio, .precios").textContent;
    const imagenesDelProducto = imagenes[id] || [producto.querySelector("img").src];

    productoActual = {
        id,
        nombre,
        precio,
        imagen: imagenesDelProducto[0],
        cantidad: 1
    };

    document.getElementById("modal-nombre").textContent = nombre;
    document.getElementById("modal-precio").textContent = precio;
    document.getElementById("modal-imagen").src = imagenesDelProducto[0];
    document.getElementById("modal-descripcion").textContent = descripciones[id] || "Sin descripción disponible.";

    const miniaturas = document.getElementById("miniaturas");
    miniaturas.innerHTML = "";

    imagenesDelProducto.forEach((img, i) => {
        const mini = document.createElement("img");
        mini.src = img;
        mini.alt = `Vista ${i + 1}`;
        mini.onclick = () => {
            document.getElementById("modal-imagen").src = img;
            productoActual.imagen = img;
        };
        miniaturas.appendChild(mini);
    });

    document.getElementById("modal-detalle").classList.remove("oculto");
}

// Cierra el modal de producto
function cerrarModal() {
    document.getElementById("modal-detalle").classList.add("oculto");
}

// Agrega el producto al carrito
function agregarAlCarrito() {
    const index = carrito.findIndex(p => p.id === productoActual.id);
    if (index !== -1) {
        carrito[index].cantidad++;
    } else {
        carrito.push({ ...productoActual });
    }
    cerrarModal();
    guardarCarrito();
    actualizarContadorCarrito();
}

// Vacía todo el carrito
function vaciarCarrito() {
    carrito = [];
    guardarCarrito();
    actualizarVistaCarrito();
    actualizarContadorCarrito();
}

// Elimina un producto específico del carrito
function eliminarDelCarrito(index) {
    carrito.splice(index, 1);
    guardarCarrito();
    actualizarVistaCarrito();
    actualizarContadorCarrito();
}

// Cambia la cantidad de un producto del carrito (+1 o -1)
function cambiarCantidad(index, cambio) {
    carrito[index].cantidad += cambio;
    if (carrito[index].cantidad <= 0) {
        carrito.splice(index, 1);
    }
    guardarCarrito();
    actualizarVistaCarrito();
    actualizarContadorCarrito();
}

// Actualiza la vista del carrito
function actualizarVistaCarrito() {
    const lista = document.getElementById("lista-carrito");
    const totalElem = document.getElementById("total-carrito");
    const vacio = document.getElementById("carrito-vacio");
    const botonFinalizar = document.getElementById("boton-finalizar");

    lista.innerHTML = "";
    let total = 0;

    if (carrito.length === 0) {
        vacio.classList.remove("oculto");
        totalElem.textContent = "";
        botonFinalizar.classList.add("oculto");
        return;
    } else {
        vacio.classList.add("oculto");
        botonFinalizar.classList.remove("oculto");
    }

    carrito.forEach((producto, i) => {
        const li = document.createElement("li");
        li.innerHTML = `
            <img src="${producto.imagen}" alt="${producto.nombre}" width="50">
            <div>
                <p>${producto.nombre}</p>
                <p>${producto.precio}</p>
                <div class="cantidad-control">
                    <button onclick="cambiarCantidad(${i}, -1)">-</button>
                    <span>${producto.cantidad}</span>
                    <button onclick="cambiarCantidad(${i}, 1)">+</button>
                </div>
            </div>
            <button onclick="eliminarDelCarrito(${i})">
                <img src="imagenes/tacho.png" class="icono-tacho" alt="Eliminar">
            </button>
        `;
        lista.appendChild(li);
        total += producto.cantidad * parseFloat(producto.precio.replace("$", "").replace(",", "."));
    });

    totalElem.textContent = `Total: $${total.toFixed(2)}`;
}

// Muestra/oculta el carrito al hacer clic en el ícono
function toggleCarrito(event) {
    event.preventDefault();
    const carritoContainer = document.getElementById("carrito-container");
    carritoContainer.classList.toggle("oculto");
    if (!carritoContainer.classList.contains("oculto")) {
        actualizarVistaCarrito();
    }
}

// Muestra la cantidad total de productos en el ícono del carrito
function actualizarContadorCarrito() {
    const contador = document.getElementById("contador-carrito");
    const cantidad = carrito.reduce((acc, prod) => acc + prod.cantidad, 0);

    if (cantidad > 0) {
        contador.textContent = cantidad;
        contador.classList.remove("oculto");
    } else {
        contador.classList.add("oculto");
    }
}

// Guarda el carrito en localStorage
function guardarCarrito() {
    localStorage.setItem("carrito", JSON.stringify(carrito));
}

// Carga el carrito desde localStorage
function cargarCarrito() {
    const guardado = localStorage.getItem("carrito");
    if (guardado) {
        carrito = JSON.parse(guardado);
    }
}

// Vacía el carrito, guarda, actualiza vista y muestra mensaje
function finalizarCompra() {
    carrito = [];
    guardarCarrito();
    actualizarVistaCarrito();
    actualizarContadorCarrito();

    // Mostrar modal de compra realizada
    document.getElementById("mensaje-compra").classList.remove("oculto");
}

function cerrarMensajeCompra() {
    document.getElementById("mensaje-compra").classList.add("oculto");
}



// Si el usuario hace clic fuera del carrito, se cierra
document.addEventListener("mousedown", function (event) {
    const carrito = document.getElementById("carrito-container");
    const iconoCarrito = document.querySelector(".carrito-link");

    const clicFueraCarrito =
        !carrito.contains(event.target) &&
        !iconoCarrito.contains(event.target);

    if (!carrito.classList.contains("oculto") && clicFueraCarrito) {
        carrito.classList.add("oculto");
    }
});

// Descripciones de productos
const descripciones = {
    "oracle1": "Mini casco edición especial Red Bull Oracle Racing 2025.",
    "oracle2": "Mini casco edición limitada color blanco dorado con visor reflectivo.",
    "mochilas5": "Mochila liviana y resistente ideal para uso urbano y deportivo.",
    // Agregá más productos según tu catálogo
};
