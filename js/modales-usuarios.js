document.addEventListener("DOMContentLoaded", () => {

  function abrirModal(overlayId, modalId, hiddenInputId, userId) {
    const overlay = document.getElementById(overlayId);
    const modal   = document.getElementById(modalId);
    const hidden  = document.getElementById(hiddenInputId);
    if (!overlay || !modal || !hidden) return;

    hidden.value = userId;
    overlay.classList.remove("oculto");
    modal.classList.remove("oculto");
    document.body.classList.add("no-scroll");
    modal.querySelector("input[type='text'], input[type='password']")?.focus();
  }

  function cerrarModal(overlayId, modalId) {
    document.getElementById(overlayId).classList.add("oculto");
    document.getElementById(modalId).classList.add("oculto");
    document.body.classList.remove("no-scroll");
  }

  // Configura un modal
  function configModal(btnSelector, overlayId, modalId, closeId, hiddenInputId) {
    // Abrir
    document.addEventListener("click", (e) => {
      const btn = e.target.closest(btnSelector);
      if (!btn) return;
      e.preventDefault();
      const id = btn.dataset.id || btn.closest("tr")?.querySelector("td")?.textContent.trim();
      if (!id) return;
      abrirModal(overlayId, modalId, hiddenInputId, id);
    });

    // Cerrar
    const closeBtn = document.getElementById(closeId);
    const overlay = document.getElementById(overlayId);
    closeBtn?.addEventListener("click", () => cerrarModal(overlayId, modalId));
    overlay?.addEventListener("click", (e) => { if (e.target === overlay) cerrarModal(overlayId, modalId); });
  }

  // Desactivar
  configModal(".accion.desactivar", "overlay-desactivar", "modal-desactivar", "cerrar-desactivar", "id-desactivar");

  // Editar
  configModal(".accion.editar", "overlay-editar", "modal-editar", "cerrar-editar", "id-editar");

  // Cambiar contraseña
  configModal(".accion.password", "overlay-password", "modal-password", "cerrar-password", "id-password");
});

function imprimirId(id) {
  console.log("ID:", id);
}