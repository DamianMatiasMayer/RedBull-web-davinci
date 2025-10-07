// js/modal-nuevo.js
document.addEventListener('DOMContentLoaded', () => {
  /** Helper: abre/cierra un par overlay+modal por id **/
  function bindModal(btnId, overlayId, modalId) {
    const btn     = document.getElementById(btnId);
    const overlay = document.getElementById(overlayId);
    const modal   = document.getElementById(modalId);

    // si falta alguno, no rompemos nada
    if (!btn || !overlay || !modal) return;

    const abrir = (e) => {
      e && e.preventDefault();
      overlay.classList.remove('oculto');
      modal.classList.remove('oculto');
      modal.querySelector('input')?.focus();
      document.body.classList.add('no-scroll');

      // Cerrar con la X del modal (busca .cerrar-modal dentro del modal)
      const x = modal.querySelector('.cerrar-modal');
      const cerrar = () => {
        overlay.classList.add('oculto');
        modal.classList.add('oculto');
        document.body.classList.remove('no-scroll');
        document.removeEventListener('keydown', onEsc);
        overlay.removeEventListener('click', onOverlay);
        x && x.removeEventListener('click', cerrar);
      };

      const onOverlay = (evt) => { if (evt.target === overlay) cerrar(); };
      const onEsc = (evt) => { if (evt.key === 'Escape' && !modal.classList.contains('oculto')) cerrar(); };

      x && x.addEventListener('click', cerrar, { once: true });
      overlay.addEventListener('click', onOverlay);
      document.addEventListener('keydown', onEsc);

      // Guardamos referencias para inspección si te sirve
      modal._cerrar = cerrar;
    };

    btn.addEventListener('click', abrir);
  }

  /** Conexiones: botón -> su modal correspondiente **/
  // Nuevo Sys Admin
  bindModal('abrir-modal-nuevo',   'overlay-nuevo-sysadmin', 'modal-nuevo-sysadmin');
  // Nuevo Administrador
  bindModal('abrir-modal-admin',   'overlay-nuevo-admin',    'modal-nuevo-admin');
  // Nuevo Usuario
  bindModal('abrir-modal-usuario', 'overlay-nuevo-usuario',  'modal-nuevo-usuario');

  /** Toggle de ojito de contraseña (global, funciona en todos los modales) */
  document.addEventListener('click', (e) => {
    const eye = e.target.closest('.campo-password i');
    if (!eye) return;
    const input = eye.closest('.campo-password')?.querySelector('input');
    if (!input) return;
    input.type = input.type === 'password' ? 'text' : 'password';
    eye.classList.toggle('fa-eye');
    eye.classList.toggle('fa-eye-slash');
  });
});
