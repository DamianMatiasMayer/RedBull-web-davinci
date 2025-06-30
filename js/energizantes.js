
//Crea un "observer" que vigila elementos para ver si están dentro de la pantalla (al menos un 10%, definido por threshold: 0.1) para la clase de css "visible".
const observer = new IntersectionObserver(
  (entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("visible");
      }
    });
  },
  { threshold: 0.1 }
);

//busca todos los elementos que tengan la clase "animar" 
document
  .querySelectorAll(".animar")
  .forEach((el) => observer.observe(el));


//esto se usa para aplicar animaciones o transicioes solo cuando los elemntos se vuelven visibles al hacer scroll.