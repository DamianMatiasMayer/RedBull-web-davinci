//apuntan a elementos del DOM para controlar productos que se pueden desplazar horizontalmente
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
    contenedor.scrollBy({ left: 1100, behavior: "smooth" });
    setTimeout(actualizarFlechas, 350);
};

flechaIzq.onclick = () => {
    contenedor.scrollBy({ left: -1100, behavior: "smooth" });
    setTimeout(actualizarFlechas, 350);
};

// Carrusel interno de imágenes, contiene arrays de rutas de imagen por ID de producto
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
        "imagenes/1-2-Max-Verstappen-WC-2024-Mini-Helmet1.1.avif",
        "imagenes/1-2-Max-Verstappen-WC-2024-Mini-Helmet1.2.avif",
        "imagenes/1-2-Max-Verstappen-WC-2024-Mini-Helmet1.3.avif",
    ],
    cascos4: [
        "imagenes/1-4-Max-Verstappen-2025-Orange-Mini-Helmet1.1.avif",
        "imagenes/1-4-Max-Verstappen-2025-Orange-Mini-Helmet1.2.avif",
        "imagenes/1-4-Max-Verstappen-2025-Orange-Mini-Helmet1.3.avif",
    ],
    cascos5: [
        "imagenes/1-2-Checo-Perez-Mexico-GP-2024-Mini-Helm1.1.avif",
        "imagenes/1-2-Checo-Perez-Mexico-GP-2024-Mini-Helm1.2.avif",
        "imagenes/1-2-Checo-Perez-Mexico-GP-2024-Mini-Helm1.3.avif",
    ],
    cascos6: [
        "imagenes/1-2-Checo-Perez-2024-Season-Mini-Helmet1.1.avif",
        "imagenes/1-2-Checo-Perez-2024-Season-Mini-Helmet1.2.avif",
        "imagenes/1-2-Checo-Perez-2024-Season-Mini-Helmet1.3.avif",
    ],
    cascos7: [
        "imagenes/1-2-Max-Verstappen-2024-Orange-Tribute-Mini-Helmet1.1.avif",
        "imagenes/1-2-Max-Verstappen-2024-Orange-Tribute-Mini-Helmet1.2.avif",
        "imagenes/1-2-Max-Verstappen-2024-Orange-Tribute-Mini-Helmet1.3.avif",
    ],
    cascos8: [
        "imagenes/1-2-Max-Verstappen-2024-Season-Mini-Helmet1.1.avif",
        "imagenes/1-2-Max-Verstappen-2024-Season-Mini-Helmet1.2.avif",
        "imagenes/1-2-Max-Verstappen-2024-Season-Mini-Helmet1.3.avif",
    ],

    //mochilas   

    mochilas1: [
        "imagenes/redbull-mochila 1.1.avif",
        "imagenes/redbull-mochila 1.2.avif",
        "imagenes/redbull-mochila 1.3.avif",
    ],
    mochilas2: [
        "imagenes/redbull-dakar-1.1.avif",
        "imagenes/redbull-dakar-1.2.avif",
        "imagenes/redbull-dakar-1.3.avif",
    ],
    mochilas3: [
        "imagenes/mochila-bora-1.1.avif",
        "imagenes/mochila-bora-1.2.avif",
        "imagenes/mochila-bora-1.3.avif",
    ],
    mochilas4: [
        "imagenes/mochila-rampage-1.1.avif",
        "imagenes/mochila-rampage-1.2.avif",
        "imagenes/mochila-rampage-1.3.avif",
    ],
    mochilas5: [
        "imagenes/bandolera-redbull-1.1.avif",
        "imagenes/bandolera-redbull-1.2.avif",
        "imagenes/bandolera-redbull-1.3.avif",
    ],
    mochilas6: [
        "imagenes/bolsa-bici-1.1.avif",
        "imagenes/bolsa-bici-1.2.avif",
        "imagenes/bolsa-bici-1.3.avif",
    ],
    mochilas7: [
        "imagenes/bandolera-redbull-azul-1.1.avif",
        "imagenes/bandolera-redbull-azul-1.2.avif",
        "imagenes/bandolera-redbull-azul-1.3.avif",
    ],
    mochilas8: [
        "imagenes/bolso-bora-1.1.avif",
        "imagenes/bolso-bora-1.2.avif",
        "imagenes/bolso-bora-1.3.avif",
    ],

    //paraguas

    paragua1: [
        "imagenes/paragua-redbull-rojo1.1.avif",
        "imagenes/paragua-redbull-rojo1.2.avif",
        "imagenes/paragua-redbull-rojo1.3.avif",
    ],
    paragua2: [
        "imagenes/paragua-redbull-bora1.1.avif",
        "imagenes/paragua-redbull-bora1.2.avif",
        "imagenes/paragua-redbull-bora1.3.avif",
    ],
    paragua3: [
        "imagenes/Grid-Pocket-Umbrella1.1.avif",
        "imagenes/Grid-Pocket-Umbrella1.2.avif",
        "imagenes/Grid-Pocket-Umbrella1.3.avif",
    ],
    paragua4: [
        "imagenes/ECM-Rink-Umbrella1.1.avif",
        "imagenes/ECM-Rink-Umbrella1.2.avif",
        "imagenes/ECM-Rink-Umbrella1.3.avif",
    ],
    paragua5: [
        "imagenes/RBL-Pocket-Umbrella1.1.avif",
        "imagenes/RBL-Pocket-Umbrella1.2.avif",
        "imagenes/RBL-Pocket-Umbrella1.3.avif",
    ],
    paragua6: [
        "imagenes/Dive-Umbrella1.1.avif",
        "imagenes/Dive-Umbrella1.2.avif",
        "imagenes/Dive-Umbrella1.3.avif",
    ],
    paragua7: [
        "imagenes/Adrenaline-Umbrella1.1.avif",
        "imagenes/Adrenaline-Umbrella1.2.avif",
        "imagenes/Adrenaline-Umbrella1.3.avif",
    ],
    paragua8: [
        "imagenes/The-Flying-Bulls-Mono-Umbrella1.1.avif",
        "imagenes/The-Flying-Bulls-Mono-Umbrella1.2.avif",
        "imagenes/The-Flying-Bulls-Mono-Umbrella1.3.avif",
    ],

    //fin paraguas

    //botellas

    botellas1: [
        "imagenes/Urban-Bottle1.1.avif",
        "imagenes/Urban-Bottle1.2.avif",
        "imagenes/Urban-Bottle1.3.avif",
    ],
    botellas2: [
        "imagenes/Frost-Bottle1.1.avif",
        "imagenes/Frost-Bottle1.2.avif",
    ],
    botellas3: [
        "imagenes/botella-rampage1.1.avif",
        "imagenes/botella-rampage1.2.avif",
        "imagenes/botella-rampage1.3.avif",
    ],
    botellas4: [
        "imagenes/Blaze-Water-Bottle1.1.avif",
        "imagenes/Blaze-Water-Bottle1.2.avif",
        "imagenes/Blaze-Water-Bottle1.3.avif",
    ],
    botellas5: [
        "imagenes/Grid-Water-Bottle1.1.avif",
        "imagenes/Grid-Water-Bottle1.2.avif",
    ],
    botellas6: [
        "imagenes/RBL-Rubin-Bottle1.1.avif",
        "imagenes/RBL-Rubin-Bottle1.2.avif",
    ],
    botellas7: [
        "imagenes/RBL-Dynamic-Bottle1.1.avif",
        "imagenes/RBL-Dynamic-Bottle1.2.avif",
    ],
    botellas8: [
        "imagenes/ECS-Ice-Bottle1.1.avif",
        "imagenes/ECS-Ice-Bottle1.2.avif",
    ],


    //fin botellas

    //guantes

    guante1: [
        "imagenes/guantes-bora1.1.avif",
        "imagenes/guantes-bora1.2.avif",
    ],
    guante2: [
        "imagenes/RBL-guante-reflectivo-niño1.1.avif",
        "imagenes/RBL-guante-reflectivo-niño1.2.avif",
    ],
    guante3: [
        "imagenes/RBL-guante-reflectivo-adulto1.1.avif",
        "imagenes/RBL-guante-reflectivo-adulto1.2.avif",
    ],
    guante4: [
        "imagenes/RBL-PUMA-colab-guantes1.1.avif",
        "imagenes/RBL-PUMA-colab-guantes1.2.avif",
    ],
    guante5: [
        "imagenes/RBS-Puma-colab-jugador1.1.avif",
        "imagenes/RBS-Puma-colab-jugador1.2.avif",
    ],
    guante6: [
        "imagenes/Pulse-Gloves1.1.avif",
        "imagenes/Pulse-Gloves1.2.avif",
        "imagenes/Pulse-Gloves1.3.avif",
    ],
    guante7: [
        "imagenes/RBL-Dawn-Gloves1.1.avif",
        "imagenes/RBL-Dawn-Gloves1.2.avif",
    ],
    guante8: [
        "imagenes/RBS-Winter-Gloves1.1.avif",
        "imagenes/RBS-Winter-Gloves1.2.avif",
    ],

    //fin guantes

    //anteojos

    anteojos1: [
        "imagenes/Red-Bull-anteojos-ski1.1.avif",
        "imagenes/Red-Bull-anteojos-ski1.2.avif",
        "imagenes/Red-Bull-anteojos-ski1.3.avif",
    ],
    anteojos2: [
        "imagenes/Red-Bull-anteojos-ski-rojo1.1.avif",
        "imagenes/Red-Bull-anteojos-ski-rojo1.2.avif",
        "imagenes/Red-Bull-anteojos-ski-rojo1.3.avif",
    ],
    anteojos3: [
        "imagenes/Red-Bull-anteojos-ski-blancos1.1.avif",
        "imagenes/Red-Bull-anteojos-ski-blancos1.2.avif",
        "imagenes/Red-Bull-anteojos-ski-blancos1.3.avif",
    ],
    anteojos4: [
        "imagenes/Red-Bull-anteojos-ski-negros1.1.avif",
        "imagenes/Red-Bull-anteojos-ski-negros1.2.avif",
        "imagenes/Red-Bull-anteojos-ski-negros1.3.avif",
    ],
    anteojos5: [
        "imagenes/anteojos-sol-blanco1.1.avif",
        "imagenes/anteojos-sol-blanco1.2.avif",
        "imagenes/anteojos-sol-blanco1.3.avif",
    ],
    anteojos6: [
        "imagenes/anteojos-sol-negro1.1.avif",
        "imagenes/anteojos-sol-negro1.2.avif",
        "imagenes/anteojos-sol-negro1.3.avif",
    ],
    anteojos7: [
        "imagenes/anteojos-sol-azul1.1.avif",
        "imagenes/anteojos-sol-azul1.2.avif",
        "imagenes/anteojos-sol-azul1.3.avif",
    ],
    anteojos8: [
        "imagenes/anteojos-sol-blancoyazul1.1.avif",
        "imagenes/anteojos-sol-blancoyazul1.2.avif",
        "imagenes/anteojos-sol-blancoyazul1.3.avif",
    ],
};

document.querySelectorAll(".producto").forEach((producto) => {  //Busca todos los elementos con la clase producto y recorre cada uno.
    const id = producto.dataset.id; //obtiene el valor del atributo id para identificar que conjunto de imagenes debe usar
    let i = 0;
    const img = producto.querySelector("img");
    const prev = producto.querySelector(".prev");
    const next = producto.querySelector(".next");

    prev.onclick = () => { //Cuando se hace clic en el botón anterior, retrocede en el array de imágenes
        i = (i - 1 + imagenes[id].length) % imagenes[id].length;
        img.src = imagenes[id][i];
    };

    next.onclick = () => { //Cuando se hace clic en el botón siguiente, avanza en el array de imágenes del producto actual.
        i = (i + 1) % imagenes[id].length;
        img.src = imagenes[id][i];
    };
});

const contenedorOracle = document.getElementById(
    "productos-scroll-oracle"
);
const flechaIzqOracle = document.getElementById("flecha-izq-oracle");
const flechaDerOracle = document.getElementById("flecha-der-oracle");

function actualizarFlechasOracle() { //Función que muestra u oculta las flechas dependiendo de cuánto se haya desplazado el scroll.
    flechaIzqOracle.style.display =
        contenedorOracle.scrollLeft > 10 ? "block" : "none"; //Muestra la flecha izquierda solo si no estamos al principio del scroll.
    const alFinal =
        contenedorOracle.scrollLeft + contenedorOracle.clientWidth >=
        contenedorOracle.scrollWidth - 10;
    flechaDerOracle.style.display = alFinal ? "none" : "block";
}

actualizarFlechasOracle();
contenedorOracle.addEventListener("scroll", actualizarFlechasOracle);

flechaDerOracle.onclick = () => { // si estamos al final, oculta la flecha derecha;si no, la muestra
    contenedorOracle.scrollBy({ left: 1100, behavior: "smooth" }); //Cuando se hace clic en la flecha derecha, se mueve 300px hacia la derecha
    setTimeout(actualizarFlechasOracle, 350);
};

flechaIzqOracle.onclick = () => { //lo mismo pero hacia la izquierda
    contenedorOracle.scrollBy({ left: -1100, behavior: "smooth" });
    setTimeout(actualizarFlechasOracle, 350);
};

document.querySelectorAll(".productos-accesorios").forEach((producto) => {//recorre todos los prodcutos en la seccion accesorios
    const id = producto.dataset.id; //Verifica si hay imágenes para ese ID en el objeto imagenes.
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