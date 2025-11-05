// js/login-error-handler.js
document.addEventListener('DOMContentLoaded', () => {
  // Tomamos el valor del parámetro "login" en la URL
  const params = new URLSearchParams(window.location.search);
  const status = params.get('login');

  if (status === 'error' || status === 'inactivo') {
    // Abre el modal y el overlay
    const modal   = document.getElementById('modal-login');
    const overlay = document.getElementById('overlay-login');
    if (modal)   modal.classList.remove('oculto');
    if (overlay) overlay.classList.remove('oculto');

    // Inyecta mensaje de error dentro del form
    const form = document.getElementById('form-login') || document.querySelector('#modal-login .form-login');
    if (form && !form.querySelector('.alerta-error-inline')) {
      const msg = (status === 'inactivo')
        ? 'Tu usuario está inactivo. Contactá al administrador.'
        : 'Email o contraseña inválidos.';

      const div = document.createElement('div');
      div.className = 'alerta-error-inline';
      div.style.cssText = `
        margin-bottom:.75rem;
        padding:.75rem 1rem;
        border:1px solid #e00;
        background:#ffe6e6;
        color:#a00;
        border-radius:.5rem;
        font-size:.9rem;
      `;
      div.textContent = msg;
      form.prepend(div);
    }
  }

  // 🔒 Toggle de ojo para mostrar/ocultar contraseña
  const eye = document.getElementById('togglePassword');
  const input = document.getElementById('login-password');
  if (eye && input) {
    eye.addEventListener('click', () => {
      input.type = (input.type === 'password') ? 'text' : 'password';
      eye.classList.toggle('fa-eye');
      eye.classList.toggle('fa-eye-slash');
    });
  }
});
