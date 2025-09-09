document.addEventListener("DOMContentLoaded", () => {
  // animar el contenedor del formulario
  gsap.from(".registro-box", { //Se usa para animar desde un estado inicial hacia el estado natural del elemento.
    duration: 1,           // duración de la animación (1s)
    opacity: 0,            // empieza invisible
    y: 50,                 // empieza 50px más abajo
    ease: "power3.out"     // curva de aceleración suave
  });

  // animar cada input uno por uno
  gsap.from(".form-registro label, .form-registro input, .btn-registrarse", {
    duration: 0.8,
    opacity: 0,
    y: 20,
    stagger: 0.15,         // retrasa cada elemento 0.15s
    ease: "power2.out",
    delay: 0.3             // empieza después del contenedor
  });

  gsap.from(".form-registro .campo-password i", {
  duration: 0.6,
  opacity: 0,
  scale: 0,
  rotation: 180,
  ease: "back.out(1.7)",
  delay: 1,
  stagger: 0.2
});

});



