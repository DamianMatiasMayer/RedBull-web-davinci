// js/gsap-anim.js
document.addEventListener("DOMContentLoaded", () => {
  // Asegura GSAP presente
  if (!window.gsap) return;

  // Registra plugin si está cargado
  if (window.ScrollTrigger) gsap.registerPlugin(ScrollTrigger);

  // =========================
  // NAV: slide-in al cargar
  // =========================
  const nav = document.querySelector("nav");
  if (nav) {
    const navFullHeight = nav.getBoundingClientRect().height;

    // 1) Aparición desde arriba
    gsap.from(nav, {
      y: -80,
      opacity: 0,
      duration: 1,
      ease: "power2.out"
    });

    // 2) Stagger de los links en la nav
    const navItems = nav.querySelectorAll("ul li");
    if (navItems.length) {
      gsap.from(navItems, {
        y: -12,
        opacity: 0,
        duration: 0.35,
        stagger: 0.08,
        ease: "power2.out",
        delay: 0.15
      });
    }

    // 3) Encoger al hacer scroll (sólo desktop/tablet anchos)
    const isWide = () => window.matchMedia("(min-width: 768px)").matches;

    const applyShrink = () => {
      // Elimina instancias previas al cambiar tamaño
      if (window.ScrollTrigger) {
        ScrollTrigger.getAll().forEach(st => {
          if (st.vars && st.vars.id === "nav-shrink") st.kill();
        });
      }

      if (!isWide() || !window.ScrollTrigger) {
        // En móvil no encogemos
        nav.style.height = "";
        nav.style.backgroundColor = "";
        return;
      }

      const targetHeight = Math.max(56, navFullHeight * 0.78);

      gsap.to(nav, {
        scrollTrigger: {
          id: "nav-shrink",
          trigger: document.body,
          start: "top top",
          end: "+=220",
          scrub: true
          // markers: true
        },
        height: targetHeight,
        backgroundColor: "#000",
        ease: "power1.out"
      });
    };

    applyShrink();
    window.addEventListener("resize", () => {
      clearTimeout(applyShrink._t);
      applyShrink._t = setTimeout(applyShrink, 150);
    });

    // (Opcional) micro-animación hover en links
    const navLinks = nav.querySelectorAll("a");
    navLinks.forEach(a => {
      a.addEventListener("mouseenter", () => {
        gsap.to(a, { y: -2, duration: 0.16, ease: "power1.out" });
      });
      a.addEventListener("mouseleave", () => {
        gsap.to(a, { y: 0, duration: 0.16, ease: "power1.out" });
      });
    });
  }

  // =========================
  // HERO (cartel del header)
  // =========================
  if (document.querySelector(".cartel h2")) {
    gsap.from(".cartel h2", {
      y: 30,
      opacity: 0,
      duration: 0.8,
      ease: "power2.out"
    });
  }

  if (document.querySelector(".cartel .btn-leer-mas")) {
    gsap.from(".cartel .btn-leer-mas", {
      y: 30,
      opacity: 0,
      duration: 0.6,
      delay: 0.15,
      ease: "power2.out"
    });
  }

  // =========================
  // NOTICIAS: reveal on scroll
  // =========================
  if (document.querySelector(".carta-noticia") && window.ScrollTrigger) {
    gsap.from(".carta-noticia", {
      scrollTrigger: {
        trigger: ".contenedor-cartas",
        start: "top 80%",
        toggleActions: "play none none none"
        // markers: true
      },
      y: 60,
      opacity: 0,
      duration: 1,
      stagger: 0.30,
      ease: "power2.out"
    });
  }

  // =========================
  // Hover "Leer más" noticias
  // =========================
  document.querySelectorAll(".boton-leer-mas-noticia").forEach((btn) => {
    btn.addEventListener("mouseenter", () => {
      gsap.to(btn, { scale: 1.05, duration: 0.15, ease: "power1.out" });
    });
    btn.addEventListener("mouseleave", () => {
      gsap.to(btn, { scale: 1.0, duration: 0.15, ease: "power1.out" });
    });
  });
});


document.addEventListener("DOMContentLoaded", () => {
  gsap.registerPlugin(ScrollTrigger);

  gsap.to(".Lata", {
    x: -40,
    duration: 1,
    ease: "power2.out",
    scrollTrigger: {
      trigger: ".Lata",
      start: "top 80%",   // cuando el top del elemento llega al 80% de la ventana
      toggleActions: "play none none none",
      // markers: true     // <- activalo para depurar
    }
  });
});
