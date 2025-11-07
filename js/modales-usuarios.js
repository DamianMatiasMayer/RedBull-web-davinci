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
    document.getElementById(overlayId)?.classList.add("oculto");
    document.getElementById(modalId)?.classList.add("oculto");
    document.body.classList.remove("no-scroll");
  }

  // Configura un modal
  function configModal(btnSelector, overlayId, modalId, closeId, hiddenInputId) {
    // Abrir (delegación)
    document.addEventListener("click", (e) => {
      const btn = e.target.closest(btnSelector);
      if (!btn) return;
      e.preventDefault();

      // intenta primero con data-id; si no, toma el primer <td> de la fila
      const id = btn.dataset.id
        || btn.closest("tr")?.querySelector("td")?.textContent.trim();

      if (!id) return;
      abrirModal(overlayId, modalId, hiddenInputId, id);
    });

    // Cerrar (botón X)
    const closeBtn = document.getElementById(closeId);
    closeBtn?.addEventListener("click", () => cerrarModal(overlayId, modalId));

    // Cerrar clickeando fuera (overlay)
    const overlay = document.getElementById(overlayId);
    overlay?.addEventListener("click", (e) => {
      if (e.target === overlay) cerrarModal(overlayId, modalId);
    });
  }

  // Desactivar
  configModal(".accion.desactivar", "overlay-desactivar", "modal-desactivar", "cerrar-desactivar", "id-desactivar");

  // Reactivar (NUEVO)
  configModal(".accion.reactivar", "overlay-reactivar", "modal-reactivar", "cerrar-reactivar", "id-reactivar");

  // Editar
  configModal(".accion.editar", "overlay-editar", "modal-editar", "cerrar-editar", "id-editar");

  // Cambiar contraseña
  configModal(".accion.password", "overlay-password", "modal-password", "cerrar-password", "id-password");

  // Cerrar cualquier modal con ESC
  document.addEventListener("keydown", (e) => {
    if (e.key !== "Escape") return;
    document.querySelectorAll(".overlay:not(.oculto)").forEach((overlay) => {
      const modal = overlay.nextElementSibling; // en tu HTML, el modal está justo después del overlay
      if (modal && modal.classList.contains("modal-login")) {
        overlay.classList.add("oculto");
        modal.classList.add("oculto");
      }
    });
    document.body.classList.remove("no-scroll");
  });
});

function imprimirId(id, accion) {
  const mapa = {
    desactivar: ["overlay-desactivar", "modal-desactivar", "id-desactivar"],
    reactivar:  ["overlay-reactivar",  "modal-reactivar",  "id-reactivar"],
    editar:     ["overlay-editar",     "modal-editar",     "id-editar"],
    password:   ["overlay-password",   "modal-password",   "id-password"],
  };

  const cfg = mapa[accion];
  if (!cfg) {
    console.warn("Acción no reconocida:", accion);
    return false;
  }

  const [overlayId, modalId, hiddenInputId] = cfg;
  const overlay = document.getElementById(overlayId);
  const modal   = document.getElementById(modalId);
  const hidden  = document.getElementById(hiddenInputId);

  if (!overlay || !modal || !hidden) {
    console.warn("No se encontraron elementos del modal:", cfg);
    return false;
  }

  // Setea el ID en el input oculto y abre el modal
  hidden.value = id;
  overlay.classList.remove("oculto");
  modal.classList.remove("oculto");
  document.body.classList.add("no-scroll");

  // Enfoca el primer input si hay
  modal.querySelector("input[type='text'], input[type='password']")?.focus();

  return false; // evita que el <a> recargue la página
}
