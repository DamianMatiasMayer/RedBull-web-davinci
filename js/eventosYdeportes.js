const autos = [
  //elemento <img> referenciado con su id
  //x: posición horizontal 
  //y: posicion vertical
  //speedX: velocidad con la que avanza en el eje X 
  { el: document.getElementById("auto1"), x: -300, y: 200, speedX: 3 },
  { el: document.getElementById("auto2"), x: 100, y: 300, speedX: 2 },
  { el: document.getElementById("auto3"), x: 500, y: 400, speedX: 2.5 },
  { el: document.getElementById("auto4"), x: 300, y: 100, speedX: 2.2 },
  { el: document.getElementById("auto5"), x: 300, y: 500, speedX: 1.7 },
];

function animar() {//funcion que se encarga de mover los autos
  autos.forEach(auto => { //recorre el array auto uno por uno
    auto.x += auto.speedX; //aumenta la posicion horizontal segun su velocidad, esto hace que se mueva a la derecha

    if (auto.x > window.innerWidth + 200) { //Si el auto se va más allá del borde derecho de la pantalla
      auto.x = -200; // lo manda devuelta al inicio (borde izquierdo)
    }//esto crea un efecto de bucle infinito

    auto.el.style.left = `${auto.x}px`; //mueve el auto horizontalmente.
    auto.el.style.top = `${auto.y}px`; // fija la ubicacion vertical
  });

  requestAnimationFrame(animar);
}

animar();



//carrousel
document.querySelectorAll('.contenedor-eventos, .contenedor-carrousel').forEach((contenedor) => {
  const carrusel = contenedor.querySelector('.carrusel-eventos, .carrusel-productos');
  const btnIzq = contenedor.querySelector('.flecha.izquierda');
  const btnDer = contenedor.querySelector('.flecha.derecha');

  if (carrusel && btnIzq && btnDer) {
    btnIzq.addEventListener('click', () => {
      carrusel.scrollBy({ left: -1500, behavior: 'smooth' });
    });

    btnDer.addEventListener('click', () => {
      carrusel.scrollBy({ left: 1280, behavior: 'smooth' });
    });
  }
});
