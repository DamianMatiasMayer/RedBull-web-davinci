document.addEventListener("DOMContentLoaded", () => {
  // Login
  const tLogin = document.getElementById("togglePasswordLogin");
  const pLogin = document.getElementById("login-password");
  if (tLogin && pLogin) {
    const flip = () => {
      pLogin.type = pLogin.type === "password" ? "text" : "password";
      tLogin.classList.toggle("fa-eye");
      tLogin.classList.toggle("fa-eye-slash");
    };
    tLogin.addEventListener("click", flip);
    tLogin.addEventListener("keydown", e => { if (e.key === "Enter" || e.key === " ") { e.preventDefault(); flip(); }});
  }

  // Registro - contraseña
  const tReg = document.getElementById("togglePasswordRegistro");
  const pReg = document.getElementById("registro-password");
  if (tReg && pReg) {
    const flip = () => {
      pReg.type = pReg.type === "password" ? "text" : "password";
      tReg.classList.toggle("fa-eye");
      tReg.classList.toggle("fa-eye-slash");
    };
    tReg.addEventListener("click", flip);
    tReg.addEventListener("keydown", e => { if (e.key === "Enter" || e.key === " ") { e.preventDefault(); flip(); }});
  }

  // Registro - confirmar
  const tReg2 = document.getElementById("toggleConfirmPasswordRegistro");
  const pReg2 = document.getElementById("registro-confirm-password");
  if (tReg2 && pReg2) {
    const flip = () => {
      pReg2.type = pReg2.type === "password" ? "text" : "password";
      tReg2.classList.toggle("fa-eye");
      tReg2.classList.toggle("fa-eye-slash");
    };
    tReg2.addEventListener("click", flip);
    tReg2.addEventListener("keydown", e => { if (e.key === "Enter" || e.key === " ") { e.preventDefault(); flip(); }});
  }
});
