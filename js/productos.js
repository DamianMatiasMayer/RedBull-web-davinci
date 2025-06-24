
const contenedor = document.getElementById("productos-scroll");
const flechaIzq = document.getElementById("flecha-izq");
const flechaDer = document.getElementById("flecha-der");

// Función para mostrar u ocultar flechas según el scroll
function actualizarFlechas() {
    // Mostrar flecha izquierda solo si no estamos al inicio
    flechaIzq.style.display = contenedor.scrollLeft > 10 ? "block" : "none";

    // Mostrar flecha derecha solo si no estamos al final
    const alFinal =
        contenedor.scrollLeft + contenedor.clientWidth >=
        contenedor.scrollWidth - 10;
    flechaDer.style.display = alFinal ? "none" : "block";
}

// Inicialmente
actualizarFlechas();

// Cuando se hace scroll manual
contenedor.addEventListener("scroll", actualizarFlechas);

// Scroll con botones
flechaDer.onclick = () => {
    contenedor.scrollBy({ left: 300, behavior: "smooth" });
    setTimeout(actualizarFlechas, 350);
};

flechaIzq.onclick = () => {
    contenedor.scrollBy({ left: -300, behavior: "smooth" });
    setTimeout(actualizarFlechas, 350);
};

// Carrusel interno de imágenes
const imagenes = {

    //productos redbull bora

    prod1: [
        "imagenes/conjunto-redbull-riders-1.3.avif",
        "imagenes/conjunto-redbull-riders-1.2.avif",
        "imagenes/conjunto-redbull-riders-1.1.avif",
    ],
    prod2: [
        "imagenes/camiseta-carrera 1.1.avif",
        "imagenes/camiseta-carrera 1.2.avif",
        "imagenes/camiseta-carrera 1.3.avif",
    ],
    prod3: [
        "imagenes/camiseta-entrenamiento 1.1.avif",
        "imagenes/camiseta-entrenamiento 1.2.avif",
        "imagenes/camiseta-entrenamiento 1.3.avif",
    ],
    prod4: [
        "imagenes/traje-carreras 1.1.avif",
        "imagenes/traje-carreras 1.2.avif",
        "imagenes/traje-carreras 1.3.avif",
    ],
    prod5: [
        "imagenes/camiseta-carrera-especial 1.1.avif",
        "imagenes/camiseta-carrera-especial 1.2.avif",
        "imagenes/camiseta-carrera-especial 1.3.avif",
    ],
    prod6: [
        "imagenes/short-termico 1.1.avif",
        "imagenes/short-termico 1.2.avif",
        "imagenes/short-termico 1.3.avif",
    ],
    prod7: [
        "imagenes/camiseta-para-clima 1.1.avif",
        "imagenes/camiseta-para-clima 1.2.avif",
        "imagenes/camiseta-para-clima 1.3.avif",
    ],
    prod8: [
        "imagenes/camiseta-larga 1.1.avif",
        "imagenes/camiseta-larga 1.2.avif",
        "imagenes/camiseta-larga 1.3.avif",
    ],
    prod9: [
        "imagenes/short-carrera 1.1.avif",
        "imagenes/short-carrera 1.2.avif",
        "imagenes/short-carrera 1.3.avif",
    ],

    //productos redbull oracle

    oracle1: [
        "imagenes/chomba-max-1.1.avif",
        "imagenes/chomba-max-1.2.avif",
        "imagenes/chomba-max-1.3.avif",
    ],
    oracle2: [
        "imagenes/remera-max 1.1.avif",
        "imagenes/remera-max 1.2.avif",
        "imagenes/remera-max 1.3.avif",
    ],
    oracle3: [
        "imagenes/chomba-max-mujer-1.1.avif",
        "imagenes/chomba-max-mujer-1.2.avif",
        "imagenes/chomba-max-mujer-1.3.avif",
    ],
    oracle4: [
        "imagenes/remera-max-femenino 1.1.avif",
        "imagenes/remera-max-femenino 1.2.avif",
        "imagenes/remera-max-femenino 1.3.avif",
    ],
    oracle5: [
        "imagenes/chaleco-oracle1.1.avif",
        "imagenes/chaleco-oracle.1.2avif.avif",
        "imagenes/chomba-max-mujer-1.3.avif",
    ],
    oracle6: [
        "imagenes/campera-oracle 1.1.avif",
        "imagenes/campera-oracle 1.2.avif",
        "imagenes/campera-oracle 1.3.avif",
    ],
    oracle7: [
        "imagenes/hoodie-oracle 1.1.avif",
        "imagenes/hoodie-oracle 1.2.avif",
        "imagenes/hoodie-oracle 1.3.avif",
    ],
    oracle8: [
        "imagenes/campera-invierno-oracle 1.1.avif",
        "imagenes/campera-invierno-oracle 1.2.avif",
        "imagenes/campera-invierno-oracle 1.3.avif",
    ],
    oracle9: [
        "imagenes/buzo-campera-oracle.avif",
        "imagenes/buzo-campera-oracle.1.2avif.avif",
        "imagenes/buzo-campera-oracle.1.3avif.avif",
    ],

    //cascos accesorios

    cascos1: [
        "imagenes/minicasco-verstappen 1.1.avif",
        "imagenes/minicasco-verstappen 1.2.avif",
        "imagenes/minicasco-verstappen 1.3.avif",
    ],
    cascos2: [
        "imagenes/minicasco-verstappen-japones 1.1.avif",
        "imagenes/minicasco-verstappen-japones 1.2.avif",
        "imagenes/minicasco-verstappen-japones 1.3.avif",
    ],
    cascos3: [
        "imagenes/casco-bicycle 1.3.avif",
        "imagenes/casco-bicycle 1.1.avif",
        "imagenes/casco-bicycle 1.2.avif",
    ],
    cascos4: [
        "imagenes/1-4-Max-Verstappen-2025-Orange-Mini-Helmet1.1.avif",
        "imagenes/1-4-Max-Verstappen-2025-Orange-Mini-Helmet1.2.avif",
        "imagenes/1-4-Max-Verstappen-2025-Orange-Mini-Helmet1.3.avif",
    ],

    //mochilas 

    mochilas1: [
        "imagenes/redbull-mochila 1.1.avif",
        "imagenes/redbull-mochila 1.2.avif",
        "imagenes/redbull-mochila 1.3.avif",
    ],
    mochilas2: [
        "imagenes/bandolera-redbull-1.1.avif",
        "imagenes/bandolera-redbull-1.2.avif",
        "imagenes/bandolera-redbull-1.3.avif",
    ],

    //otros accesorios

    accesorios1: [
        "imagenes/paraguas-redbull 1.1.avif",
        "imagenes/paraguas-redbull 1.2.avif",
        "imagenes/paraguas-redbull 1.3.avif",
    ],
    accesorios2: [
        "imagenes/botella-redbull 1.1.avif",
        "imagenes/botella-redbull 1.2.avif",
        "imagenes/botella-redbull 1.3.avif",
    ],
    //accesorios3: [
        //"imagenes/bandolera-redbull-1.1.avif",
        //"imagenes/bandolera-redbull-1.2.avif",
        //"imagenes/bandolera-redbull-1.3.avif",
    //],
    accesorios4: [
        "imagenes/modelo-escala-1.1.avif",
        "imagenes/modelo-escala-1.2.avif",
        "imagenes/modelo-escala-1.3.avif",
    ],
    accesorios5: [
        "imagenes/tarjetero-redbull 1.1.avif",
        "imagenes/tarjetero-redbull 1.2.avif",
    ],
    accesorios6: [
        "imagenes/taza-redbull 1.1.avif",
        "imagenes/taza-redbull 1.2.avif",
    ],
    accesorios7: [
        "imagenes/lapicera-redbull 1.1.avif",
        "imagenes/lapicera-redbull 1.2.avif",
    ],
    accesorios8: [
        "imagenes/pin-redbull 1.1.avif",
        "imagenes/pin-redbull 1.2.avif",
    ],
};

document.querySelectorAll(".producto").forEach((producto) => {
    const id = producto.dataset.id;
    let i = 0;
    const img = producto.querySelector("img");
    const prev = producto.querySelector(".prev");
    const next = producto.querySelector(".next");

    prev.onclick = () => {
        i = (i - 1 + imagenes[id].length) % imagenes[id].length;
        img.src = imagenes[id][i];
    };

    next.onclick = () => {
        i = (i + 1) % imagenes[id].length;
        img.src = imagenes[id][i];
    };
});

const contenedorOracle = document.getElementById(
    "productos-scroll-oracle"
);
const flechaIzqOracle = document.getElementById("flecha-izq-oracle");
const flechaDerOracle = document.getElementById("flecha-der-oracle");

function actualizarFlechasOracle() {
    flechaIzqOracle.style.display =
        contenedorOracle.scrollLeft > 10 ? "block" : "none";
    const alFinal =
        contenedorOracle.scrollLeft + contenedorOracle.clientWidth >=
        contenedorOracle.scrollWidth - 10;
    flechaDerOracle.style.display = alFinal ? "none" : "block";
}

actualizarFlechasOracle();
contenedorOracle.addEventListener("scroll", actualizarFlechasOracle);

flechaDerOracle.onclick = () => {
    contenedorOracle.scrollBy({ left: 300, behavior: "smooth" });
    setTimeout(actualizarFlechasOracle, 350);
};

flechaIzqOracle.onclick = () => {
    contenedorOracle.scrollBy({ left: -300, behavior: "smooth" });
    setTimeout(actualizarFlechasOracle, 350);
};

document.querySelectorAll(".productos-accesorios").forEach((producto) => {
    const id = producto.dataset.id;
    if (!imagenes[id]) return;
    let i = 0;
    const img = producto.querySelector("img");
    const prev = producto.querySelector(".prev");
    const next = producto.querySelector(".next");

    if (prev && next) {
        prev.onclick = () => {
            i = (i - 1 + imagenes[id].length) % imagenes[id].length;
            img.src = imagenes[id][i];
        };

        next.onclick = () => {
            i = (i + 1) % imagenes[id].length;
            img.src = imagenes[id][i];
        };
    }
});