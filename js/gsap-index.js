
document.addEventListener("DOMContentLoaded", () => {
  if (!window.gsap) return;
  if (window.ScrollTrigger) gsap.registerPlugin(ScrollTrigger);

  // HERO
  if (document.querySelector(".cartel h2")) {
    gsap.from(".cartel h2", {
      y: 30, opacity: 0, duration: 0.8, ease: "power2.out"
    });
  }
  if (document.querySelector(".cartel .btn-leer-mas")) {
    gsap.from(".cartel .btn-leer-mas", {
      y: 30, opacity: 0, duration: 0.6, delay: 0.15, ease: "power2.out"
    });
  }

  // NOTICIAS
  if (document.querySelector(".carta-noticia") && window.ScrollTrigger) {
    gsap.from(".carta-noticia", {
      scrollTrigger: {
        trigger: ".contenedor-cartas",
        start: "top 80%",
        toggleActions: "play none none none"
      },
      y: 60, opacity: 0, duration: 1, stagger: 0.30, ease: "power2.out"
    });
  }

  // Lata (scroll)
  if (document.querySelector(".Lata") && window.ScrollTrigger) {
    gsap.to(".Lata", {
      x: -40, duration: 1, ease: "power2.out",
      scrollTrigger: {
        trigger: ".Lata",
        start: "top 80%",
        toggleActions: "play none none none"
      }
    });
  }

  // Hover "Leer más" noticias
  document.querySelectorAll(".boton-leer-mas-noticia").forEach((btn) => {
    btn.addEventListener("mouseenter", () => {
      gsap.to(btn, { scale: 1.05, duration: 0.15, ease: "power1.out" });
    });
    btn.addEventListener("mouseleave", () => {
      gsap.to(btn, { scale: 1.0, duration: 0.15, ease: "power1.out" });
    });
  });
});
