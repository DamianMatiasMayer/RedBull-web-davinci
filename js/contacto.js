


document.addEventListener('DOMContentLoaded', function () {

  //selecciona el formulario con clase .formulario-contacto
  const formulario = document.querySelector('.formulario-contacto');
  //seleccion el contenedor donde se va a mostrar el mensaje de exito con id mensaje-exito
  const mensaje = document.getElementById('mensaje-exito');

  //cuando el usuario hace clic en el boton "enviar"
  formulario.addEventListener('submit', function (e) {

    e.preventDefault();

    //Cambia el texto del mensaje de éxito.
    mensaje.textContent = '¡Gracias! Tu mensaje fue enviado correctamente. Nos pondremos en contacto a la brevedad.';
    mensaje.style.display = 'block';

    // Limpia todos los campos del formulario.
    formulario.reset();
  });
});