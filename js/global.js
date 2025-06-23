function mostrarAviso(e) {
  e.preventDefault();
  const aviso = document.getElementById("aviso-trabajo");
  aviso.classList.remove("oculto");

  setTimeout(() => {
    aviso.classList.add("oculto");
  }, 3000); // lo oculta después de 3 segundos
}
