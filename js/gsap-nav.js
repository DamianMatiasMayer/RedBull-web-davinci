
document.addEventListener("DOMContentLoaded", () => {
  // Asegura GSAP presente
  if (!window.gsap) return;

  // Registra plugin si está cargado
  if (window.ScrollTrigger) gsap.registerPlugin(ScrollTrigger);

  const nav = document.querySelector("nav");
  if (!nav) return;

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

  // 3) Encoger al hacer scroll (solo desktop/tablet anchos)
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
});
