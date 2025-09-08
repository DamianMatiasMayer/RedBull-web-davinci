document.addEventListener("DOMContentLoaded", () => {
  const btnsAbrirLogin = document.querySelectorAll(".link-usuario, .registro-footer a");
  const overlay = document.getElementById("overlay-login"); //fondo oscuro detrás del modal.
  const modal = document.getElementById("modal-login"); //la ventana de login.
  const btnCerrar = modal.querySelector(".cerrar-modal"); //el botón de la X para cerrar.

 btnsAbrirLogin.forEach((btn) => {
  btn.addEventListener("click", (e) => {
    e.preventDefault(); // evita que navegue a otra página
    overlay.classList.remove("oculto");// muestra el fondo oscuro
    modal.classList.remove("oculto");// muestra el modal
    const firstInput = modal.querySelector("input");
    if (firstInput) firstInput.focus();// pone el cursor en el primer campo
  });
});

  function cerrar() { // función para cerrar el modal
    overlay.classList.add("oculto");
    modal.classList.add("oculto");
  }

  // Cerrar con click en el fondo o en la X
  overlay.addEventListener("click", cerrar);
  btnCerrar.addEventListener("click", cerrar);

  // Cerrar con ESC
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && !modal.classList.contains("oculto")) cerrar();
  });
});

 //mostrar/ocultar
const togglePassword = document.getElementById("togglePassword");
const passwordInput = document.getElementById("login-password");

togglePassword.addEventListener("click", () => {
  const type = passwordInput.type === "password" ? "text" : "password";
  passwordInput.type = type;

  togglePassword.classList.toggle("fa-eye");
  togglePassword.classList.toggle("fa-eye-slash");
});

