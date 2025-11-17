<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>RedBull Contacto</title>
    <link rel="stylesheet" href="css/global.css" />
    <link rel="stylesheet" href="css/contacto.css" />
    <link rel="stylesheet" href="css/modal-carrito.css" />
    <link rel="stylesheet" href="css/modal-login.css">
    <link
      href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;700&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    />
    <!-- fontawesome para los iconos -->
    <link rel="icon" href="imagenes/favicon.redbull.jpg.png" />
    <!-- icono pestaña navegador -->
  </head>

  <script src="js/contacto.js"></script>

  <body>
    <!-- logo y  navegacion -->

  <header>
    <?php
        include 'nav.php';
    ?>

      <!-- mensaje sobre imagen -->

      <div class="texto-sobre-imagen">
        <h1>¿en qué podemos ayudarte?</h1>
      </div>

      <!-- FIN mensaje sobre imagen -->
  </header>

    <!--fin logo y  navegacion -->

    <main>
      <!--seccion de contacto con formulario -->

      <section class="bloque-inclinado-contacto">
        <div class="contenido-inclinado">
          <h2>Estamos para ayudarte</h2>

          <p>
            Completá el formulario o encontrá información útil para resolver tus
            dudas.
          </p>

          <form action="#" method="post" class="formulario-contacto">
            <input
              type="text"
              name="nombre"
              placeholder="Nombre completo"
              required
            />
            <input
              type="email"
              name="email"
              placeholder="Correo electrónico"
              required
            />
            <input type="text" name="asunto" placeholder="Asunto" required />
            <textarea
              name="mensaje"
              rows="5"
              placeholder="Escribí tu mensaje..."
              required
            ></textarea>
            <button type="submit"><span>Enviar</span></button>
          </form>

          <div id="mensaje-exito" class="mensaje-exito"></div>

          <div class="info-contacto">
            <h3>
              <i class="fas fa-envelope-open-text"></i> CONTACTAR A RedBull
            </h3>
            <p><i class="fas fa-location-dot"></i> RedBull Argentina</p>
            <p>
              <i class="fas fa-map-marker-alt"></i> Av. del Libertador 7208,
              C1429 Cdad. Autónoma de Buenos Aires
            </p>
            <p><i class="fas fa-clock"></i> Lunes a Viernes: 8 AM - 5 PM PST</p>
            <p><i class="fas fa-phone"></i> 11 4137-3330</p>
            <p><i class="fas fa-phone"></i> 11 4267-7890</p>
          </div>
        </div>
      </section>

      <!--fin seccion formulario -->

      <!-- MODAL DE DETALLE DE PRODUCTO -->
      <div id="modal-detalle" class="modal oculto">
        <div class="modal-producto">
          <span class="cerrar" onclick="cerrarModal()">&times;</span>

          <div class="modal-izq">
            <div class="galeria-miniaturas" id="miniaturas"></div>
            <img
              id="modal-imagen"
              class="imagen-grande"
              src=""
              alt="Imagen principal del producto"
            />
          </div>
          <div class="modal-der">
            <h2 id="modal-nombre"></h2>
            <p id="modal-descripcion" class="modal-descripcion"></p>
            <p id="modal-precio" class="modal-precio"></p>
            <button onclick="agregarAlCarrito()" class="boton-agregar">
              Agregar al carrito
            </button>
          </div>
        </div>
      </div>

      <!-- CARRITO LATERAL -->
      <div id="carrito-container" class="carrito oculto">
        <div class="carrito-header">
          <h3>Tu Carrito</h3>
          <button class="cerrar-carrito" onclick="toggleCarrito(event)">
            X
          </button>
        </div>
        <div id="lista-carrito" class="contenido-carrito"></div>
        <p id="carrito-vacio" class="carrito-vacio oculto">
          TU CARRITO ESTÁ VACÍO
        </p>
        <p id="total-carrito" class="carrito-total"></p>
        <button
          id="boton-finalizar"
          class="boton-finalizar oculto"
          onclick="finalizarCompra()"
        >
          Finalizar compra
        </button>
      </div>

      <!-- MENSAJE DE COMPRA REALIZADA CON EXITO  -->
      <div id="mensaje-compra" class="modal-compra oculto">
        <div class="modal-compra-contenido">
          <h2>¡Gracias por tu compra!</h2>
          <p>Tu pedido fue procesado con éxito.</p>
          <button onclick="cerrarMensajeCompra()">Cerrar</button>
        </div>
      </div>
    </main>

  <!-- Footer   -->

    <?php
        include 'footer.php';
    ?>

  <!-- Fin Footer   -->

    <!-- Modal de inicio de sesion/registro   -->

  <!-- Overlay oscuro -->
  <div id="overlay-login" class="overlay oculto"></div>

  <!-- Modal de Login -->

  <?php include 'login.php'; ?>

  <!--Fin Modal de inicio de sesion/registro   -->

    <!-- Aviso emergente en trabajo  -->

    <div id="aviso-trabajo" class="aviso-trabajo oculto">
      🔧 Esta sección está en desarrollo. ¡Pronto estará disponible!
    </div>
    <!-- Fin Aviso   -->

    <!-- GSAP -->
  <script defer src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
  <!-- ScrollTrigger (para animar con el scroll) -->
  <script defer src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

    <!-- Scripts -->
    <script defer src="js/global.js"></script>
    <script defer src="js/modal-carrito.js"></script>
    <script defer src="js/gsap-nav.js"></script>
    <script defer src="js/login.js"></script>
  </body>
</html>
