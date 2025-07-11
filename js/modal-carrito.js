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

    //descripcion de cascos
    "cascos1": "Revive la emoción de la Fórmula 1 con esta réplica en miniatura del casco oficial Red Bull Oracle Racing 2025. Diseñado con detalles de alta precisión, este artículo de colección celebra la velocidad, la innovación y el espíritu competitivo del equipo. Ideal para fanáticos, coleccionistas y amantes del automovilismo. ¡Llevá la adrenalina de la pista a tu hogar!",
    "cascos2": "Celebrá la temporada 2025 con esta exclusiva edición limitada del mini casco Red Bull Oracle Racing, inspirado en la cultura japonesa. Con un diseño único y detalles que rinden homenaje al Gran Premio de Japón, esta pieza de colección combina arte, velocidad y precisión. Fabricado con materiales de alta calidad, es el complemento perfecto para fanáticos de la F1 y seguidores del equipo Red Bull. ¡Edición limitada, disponible por tiempo limitado!",
    "cascos3": "Réplica oficial del casco usado por Max Verstappen en la temporada 2024. Detalles de alta calidad y diseño auténtico del campeón.",
    "cascos4": "Réplica a escala 1:2 del casco naranja de Max Verstappen para la temporada 2025. Edición especial con acabados premium y diseño oficial Red Bull Racing.",
    "cascos5":"Réplica a escala 1:2 del casco especial que Checo Pérez usó en el Gran Premio de México 2024. Diseño conmemorativo, ideal para fanáticos y coleccionistas.",
    "cascos6":"Réplica oficial a escala 1:2 del casco de Checo Pérez usado durante la temporada 2024. Detalles de alta calidad y diseño Red Bull Racing.",
    "cascos7":"Réplica a escala 1:2 del casco naranja de Max Verstappen para la temporada 2024. Diseño distintivo y acabados de colección, ideal para fanáticos de Red Bull Racing.",
    "cascos8":"Réplica exclusiva del casco especial EA Sports de Max Verstappen, temporada 2024. Diseño único y detalles premium en escala 1:2.",

    //descripcion de paraguas
    "paragua1":"Paraguas resistente y liviano con diseño oficial ECS. Ideal para protegerte de la lluvia con estilo y comodidad.",
    "paragua2":"Compacto, liviano y fácil de llevar. El paraguas Essential es ideal para llevar en la mochila o cartera y estar siempre preparado.",
    "paragua3":"Diseño moderno y compacto. El paraguas Grid combina funcionalidad y estilo, ideal para llevar a todos lados sin ocupar espacio.",
    "paragua4":"Estilo y protección en cualquier clima. El paraguas ECM Rink ofrece un diseño elegante y estructura resistente, ideal para el uso diario.",
    "paragua5":"Ligero, plegable y con diseño Red Bull Racing. El paraguas RBL de bolsillo es perfecto para llevar a todos lados y enfrentar la lluvia con estilo.",
    "paragua6":"Diseño moderno y estructura resistente. El paraguas Dive es ideal para quienes buscan funcionalidad y estilo en los días de lluvia.",
    "paragua7":"Inspirado en la velocidad y la energía. El paraguas Adrenaline combina diseño deportivo con resistencia, perfecto para cualquier clima.",
    "paragua8":"Estilo clásico con el sello Flying Bulls. Compacto, funcional y con diseño monocromático, ideal para acompañarte en cualquier día de lluvia.",

    //descripcion de botellas
    "botellas1": "Diseño moderno y práctico para el día a día. La botella RB Urbana es ideal para mantenerte hidratado con estilo Red Bull en todo momento.",
    "botellas2": "Diseño elegante con acabado esmerilado. La botella RB Frost combina estilo y funcionalidad, ideal para bebidas frías en cualquier ocasión.",
    "botellas3": "Robusta y con estilo deportivo. La botella RB Rampage está diseñada para acompañarte en tus entrenamientos o aventuras con el espíritu Red Bull.",
    "botellas4": "Con diseño vibrante y gran resistencia, la botella RB Blaze es perfecta para acompañarte en tu rutina diaria con energía y estilo Red Bull.",
    "botellas5": "Diseño urbano y moderno inspirado en la velocidad. La botella RB Grid es ideal para el uso diario, combinando funcionalidad con el estilo Red Bull Racing.",
    "botellas6": "Estilo sofisticado con identidad Red Bull. La botella RBL Rubin destaca por su diseño elegante y práctico, ideal para hidratarte con clase en cualquier ocasión.",
    "botellas7": "Diseño deportivo y funcional con el sello Red Bull. La botella RBL Dynamic es perfecta para acompañarte en movimiento, ideal para el día a día o entrenamientos.",
    "botellas8": "La botella ECS Ice combina practicidad y estilo, ideal para el uso diario. Perfecta para mantener tus bebidas frías durante todo el día gracias a su construcción funcional y liviana.",

    //descripcion de guantes
    "guante1": "Con diseño ergonómico y ajuste cómodo, los guantes Bora Sport están pensados para el rendimiento. Ideales para entrenamientos o actividades al aire libre con estilo Red Bull.",
    "guante2": "Cómodos, livianos y con detalles reflectivos para mayor seguridad. Los guantes RBL para niños combinan estilo Red Bull con funcionalidad en cada salida.",
    "guante3": "Diseño urbano con detalles reflectivos para mayor visibilidad. Los guantes RBL para adulto ofrecen comodidad, abrigo y estilo Red Bull para el día a día.",
    "guante4": "Fusión de estilo y rendimiento. Los guantes de la colaboración Red Bull Racing x Puma ofrecen ajuste preciso, materiales de calidad y diseño deportivo exclusivo.",
    "guante5": "Diseñados para alto rendimiento, los guantes RBL x Puma “Jugador” combinan tecnología deportiva, agarre óptimo y el estilo oficial de Red Bull Racing.",
    "guante6": "Diseño deportivo y materiales de alto rendimiento. Los guantes RB Pulse brindan comodidad, agarre y estilo para acompañarte en cada entrenamiento o salida urbana.",
    "guante7": "Elegantes y funcionales, los guantes RBL Dawn ofrecen abrigo y confort con el estilo distintivo de Red Bull Racing. Ideales para el uso diario en climas fríos.",
    "guante8": "Pensados para el frío extremo, los guantes RBS Invierno combinan abrigo, comodidad y estilo Red Bull Salzburg. Ideales para mantener tus manos protegidas en días helados.",

    //descripcion de mochilas
    "mochilas1": "Diseño oficial Red Bull Racing Oracle, ideal para el día a día o escapadas. Resistente, funcional y con el estilo de la F1, perfecta para fanáticos del equipo.",
    "mochilas2": "Inspirada en la aventura y la resistencia del Rally Dakar. La mochila RB Dakar combina durabilidad, múltiples compartimentos y el estilo audaz de Red Bull.",
    "mochilas3": "Estilo urbano con espíritu deportivo. La mochila RB Bora ofrece practicidad, comodidad y el diseño distintivo de Red Bull para acompañarte a donde vayas.",
    "mochilas4": "Diseñada para la acción. La mochila RB Rampage combina resistencia, gran capacidad y un estilo agresivo inspirado en el espíritu extremo de Red Bull.",
    "mochilas5": "Compacta, práctica y con estilo Red Bull. La bandolera RB es ideal para llevar lo esencial con comodidad, perfecta para el uso diario o eventos deportivos.",
    "mochilas6": "Funcional y resistente, la bolsa RB Bora se adapta fácilmente a tu bici. Ideal para transportar objetos personales con seguridad y estilo Red Bull mientras pedaleás.",
    "mochilas7": "Diseño compacto y moderno en color azul Red Bull. Ideal para llevar lo esencial con estilo, ya sea en la ciudad o en eventos deportivos.",
    "mochilas8": "Amplio, resistente y con diseño deportivo. El bolso RB Bora es ideal para viajes cortos, entrenamientos o uso diario, con el inconfundible estilo Red Bull.",
    
    //descripcion de anteojos/Goggles
    "anteojos1": "Diseñadas para el rendimiento en la nieve. Las gafas de ski RB SPECT SOLO-011S ofrecen visión clara, protección UV y un ajuste cómodo. Estilo Red Bull y tecnología de alto nivel para tus aventuras en la montaña.",
    "anteojos2": "Gafas de ski de alto rendimiento con diseño Red Bull SPECT. El modelo SOLO-004 ofrece protección UV, visión panorámica y comodidad total para disfrutar al máximo en la nieve.",
    "anteojos3": "Con un diseño moderno y envolvente, las gafas RB SPECT SOLO-012S brindan protección total contra rayos UV, visión clara en condiciones extremas y un ajuste cómodo compatible con casco. Ideales para los amantes de la nieve y la velocidad.",
    "anteojos4": "Diseñadas para la acción en la nieve, las gafas RB SPECT SOLO-009S ofrecen lentes de alta calidad con protección UV, tratamiento antivaho y un ajuste cómodo. Rendimiento y estilo Red Bull para tus días en la montaña.",
    "anteojos5": "Estilo deportivo y protección total. Los anteojos de sol RB Dundee-004 combinan diseño moderno, lentes con filtro UV y el espíritu Red Bull para acompañarte en cada aventura.",
    "anteojos6": "Diseño liviano y deportivo con estilo Red Bull. Los anteojos Dundee-001 ofrecen protección UV y comodidad para el uso diario o actividades al aire libre.",
    "anteojos7": "Estilo audaz y protección superior. Los anteojos de sol RB SPECT DAFT-004 combinan un diseño envolvente con lentes de alta calidad y protección UV, ideales para un look deportivo con actitud Red Bull.",
    "anteojos8": "Diseño moderno con inspiración outdoor. Los anteojos RB SPECT DAKOTA-002 ofrecen protección UV, comodidad y un estilo versátil ideal para la aventura y el uso diario.",

    //descripcion de productos redbull oracle
    "oracle1": "Elegancia deportiva con el estilo del campeón. La chomba Max Verstappen combina confort, diseño Red Bull Racing y detalles que rinden homenaje al piloto neerlandés.",
    "oracle2": "Estilo casual con ADN de campeón. La remera Max Verstappen luce el diseño Red Bull Racing y detalles exclusivos del piloto, ideal para fanáticos de la F1.",
    "oracle3": "Diseño entallado y estilo Red Bull Racing. La chomba femenina Max Verstappen combina elegancia y pasión por la F1, ideal para fanáticas del campeón neerlandés.",
    "oracle4": "Con corte femenino y diseño oficial Red Bull Racing, esta remera celebra el espíritu competitivo de Max Verstappen. Ideal para mostrar tu pasión por la F1 con estilo.",
    "oracle5": "Funcional y con estilo racing. El chaleco Red Bull Oracle ofrece abrigo liviano, libertad de movimiento y diseño oficial del equipo, ideal para fanáticos de la F1.Funcional y con estilo racing. El chaleco Red Bull Oracle ofrece abrigo liviano, libertad de movimiento y diseño oficial del equipo, ideal para fanáticos de la F1.",
    "oracle6": "Abrigo, confort y diseño oficial del equipo Red Bull Racing. La campera Red Bull Oracle combina estilo deportivo con materiales de calidad, ideal para lucir tu pasión por la F1 en cualquier clima.",
    "oracle7": "Estilo deportivo y comodidad en un solo diseño. El buzo Red Bull Oracle presenta el look oficial del equipo con detalles de calidad, ideal para fanáticos de la F1 dentro y fuera de la pista.",
    "oracle8": "Preparada para el frío, con el estilo del equipo Red Bull Racing. Esta campera de invierno brinda abrigo térmico, materiales resistentes y diseño oficial para fanáticos que no paran ni en los días más helados.",
    "oracle9": "Comodidad de buzo con look de campera. Diseño deportivo y versátil con detalles oficiales Red Bull Racing, ideal para el día a día o completar tu outfit de fanático.", 

    //descripcion de productos redbull bora
    "prod1": "Diseño técnico y resistente al viento. La chaqueta SoftShell Riders ofrece abrigo ligero, libertad de movimiento y estilo deportivo, ideal para actividades al aire libre y uso urbano.",
    "prod2": "Estilo deportivo con inspiración de pista. La camiseta TGA Carrera combina diseño liviano, comodidad y espíritu automovilístico, ideal para los fanáticos de la velocidad.",
    "prod3": "Ligera, cómoda y diseñada para el rendimiento. Ideal para entrenamientos intensos o uso diario, con materiales que favorecen la ventilación y libertad de movimiento.",
    "prod4": "Diseñado para el rendimiento sobre ruedas. El traje corto de carretera Carrera ofrece ajuste aerodinámico, comodidad y transpirabilidad para ciclistas que buscan velocidad y eficiencia.",
    "prod5": "Diseño liviano y deportivo, ideal para correr con libertad y confort. La camiseta Carrera ofrece transpirabilidad, ajuste cómodo y un estilo pensado para el movimiento.",
    "prod6": "Confeccionado para mantener el calor y brindar soporte. El short térmico corto es ideal para entrenamientos en climas fríos, con ajuste cómodo y tejido técnico que retiene la temperatura sin perder movilidad.",
    "prod7": "Ligera, transpirable y de secado rápido. Ideal para entrenamientos o actividades al aire libre en días calurosos, brindando frescura y comodidad en cada movimiento.",
    "prod8": "Versátil y cómoda, ideal para climas frescos o capas intermedias. Confeccionada en tejido suave y respirable, brinda abrigo ligero sin limitar el movimiento.",
    "prod9": "Diseñada para la velocidad y el rendimiento. La camiseta Carrera TGA ofrece ajuste atlético, transpirabilidad y un estilo deportivo ideal para entrenamientos o competencias.",

};
