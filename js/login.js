document.addEventListener("DOMContentLoaded", () => {
  const btnUsuario = document.querySelector(".link-usuario");
  const overlay = document.getElementById("overlay-login");
  const modal = document.getElementById("modal-login");
  const btnCerrar = modal.querySelector(".cerrar-modal");

  if (btnUsuario) {
    btnUsuario.addEventListener("click", (e) => {
      e.preventDefault(); // que no intente navegar
      overlay.classList.remove("oculto");
      modal.classList.remove("oculto");
      // foco en el primer input
      const firstInput = modal.querySelector("input");
      if (firstInput) firstInput.focus();
    });
  }

  function cerrar() {
    overlay.classList.add("oculto");
    modal.classList.add("oculto");
  }

  overlay.addEventListener("click", cerrar);
  btnCerrar.addEventListener("click", cerrar);

  // Cerrar con ESC
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && !modal.classList.contains("oculto")) cerrar();
  });
});
