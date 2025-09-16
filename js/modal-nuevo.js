// js/modal-nuevo.js
document.addEventListener("DOMContentLoaded", () => {
  const abrir  = document.getElementById("abrir-modal-nuevo");
  const overlay = document.getElementById("overlay-nuevo");
  const modal   = document.getElementById("modal-nuevo");
  const cerrar  = document.getElementById("cerrar-modal-nuevo");

  if (!abrir || !overlay || !modal || !cerrar) {
    console.warn("Modal Nuevo: faltan elementos en el DOM");
    return;
  }

  /* ==== Abrir / Cerrar Modal ==== */
  function abrirModal(e) {
    e?.preventDefault();
    overlay.classList.remove("oculto");
    modal.classList.remove("oculto");
    modal.querySelector("input")?.focus();
    document.body.classList.add("no-scroll");
  }

  function cerrarModal() {
    overlay.classList.add("oculto");
    modal.classList.add("oculto");
    document.body.classList.remove("no-scroll");
  }

  abrir.addEventListener("click", abrirModal);
  cerrar.addEventListener("click", cerrarModal);
  overlay.addEventListener("click", (e) => { if (e.target === overlay) cerrarModal(); });

  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && !modal.classList.contains("oculto")) cerrarModal();
  });

  /* ==== Toggle password (ojito) dentro del modal ==== */
  modal.addEventListener("click", (e) => {
    // Busca si se hizo clic en un icono <i> dentro de .campo-password
    const eye = e.target.closest(".campo-password i");
    if (!eye) return;

    const input = eye.closest(".campo-password")?.querySelector("input");
    if (!input) return;

    // Alternar tipo de input
    input.type = input.type === "password" ? "text" : "password";

    // Cambiar icono FontAwesome
    eye.classList.toggle("fa-eye");
    eye.classList.toggle("fa-eye-slash");
  });
});
