// funcion para mostrar aviso que la pagina aun esta en trabajo

function mostrarAviso(e) {
  e.preventDefault();
  const aviso = document.getElementById("aviso-trabajo");//Busca el elemento HTML con el ID aviso-trabajo, que se supone es un mensaje oculto.
  aviso.classList.remove("oculto");

  setTimeout(() => {
    aviso.classList.add("oculto");
  }, 3000); // lo oculta después de 3 segundos
}

//Al hacer clic en un link que tiene onclick="mostrarAviso(event)", aparece el mensaje por 3 segundos y luego desaparece.


//boton hamburguesa

  const hamburguesa = document.getElementById('hamburguesa');
  const menu = document.querySelector('nav ul');

  hamburguesa.addEventListener('click', () => {
    menu.classList.toggle('mostrar');
  });