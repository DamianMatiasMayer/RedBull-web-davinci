document.addEventListener('DOMContentLoaded', function () {
  const formulario = document.querySelector('.formulario-contacto');
  const mensaje = document.getElementById('mensaje-exito');

  formulario.addEventListener('submit', function (e) {
    e.preventDefault();

    mensaje.textContent = '¡Gracias! Tu mensaje fue enviado correctamente. Nos pondremos en contacto a la brevedad.';
    mensaje.style.display = 'block';

    formulario.reset();
  });
});