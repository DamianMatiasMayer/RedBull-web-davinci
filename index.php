<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RedBull</title>
  <link rel="stylesheet" href="css/global.css" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/modal-carrito.css" />
  <link rel="stylesheet" href="css/modal-login.css">
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="icon" href="imagenes/favicon.redbull.jpg.png" />
  <!-- icono pestaña navegador -->
</head>

<body>
  <!-- logo y  navegacion -->
  <header>
    
    <?php
        include 'nav.php';
    ?>
    <!-- fin logo y  navegacion -->

    <!--  inicioCartel sobre la imagen -->
    <div class="cartel">
      <h2>
        Precisión, velocidad y control absoluto: el arte del aerobatic flying
        llevado al límite.
      </h2>
      <a href="eventosYdeportes.php" class="btn-leer-mas"><span>Leer más</span></a>
    </div>

    <!-- fin Cartel sobre la imagen -->
  </header>

  <main>
    <!-- bloque con borde redondeado + lata  -->
    <section class="bloque-con-borde">
      <div class="Lata">
        <img src="imagenes/DRES_AR_ED-250ml_cold_closed_front_redbullcom.webp" alt="Lata Red Bull" />

        <div class="texto-lata">
          <h1>Productos Red Bull Energy Drink</h1>

          <p>
            Red Bull Energy Drink es reconocida mundialmente por los mejores
            atletas y estudiantes, al igual que en profesiones de alta demanda
            y largas jornadas de manejo.
          </p>

          <a href="energizantes.php" class="btn-productos"><span>Todos los energizantes</span></a>
        </div>
      </div>
    </section>

    <!-- FIN bloque con borde redondeado + lata  -->

    <!-- bloque con borde inclinado   -->

    <section class="bloque-inclinado">
      <div class="contenido-inclinado">
        <h2>Explorá más contenidos</h2>
        <p>
          Descubrí todo lo que Red Bull tiene para ofrecer: deportes extremos,
          cultura, música y más.
        </p>
      </div>

      <!-- Noticias  -->
      <div class="noticias">
        <h2 class="titulo-noticias">Últimas noticias</h2>

        <div class="contenedor-cartas">
          <!-- Noticia 1 -->
          <article class="carta-noticia">
            <div class="imagen-carta" style="
                  background-image: url('imagenes/red-bull-racing-rb21-2025-suzuka-gp-livery.avif');
                "></div>
            <div class="contenido-carta">
              <p class="categoria">F1</p>
              <h3>
                Max Verstappen y Yuki Tsunoda se enfrentan en Suzuka este fin
                de semana, mientras Oracle Red Bull Racing celebra una
                colaboración icónica con una decoración especial.
              </h3>
              <a href="eventosYdeportes.php" class="boton-leer-mas-noticia">Leer más</a>
            </div>
          </article>

          <!-- Noticia 2 -->
          <article class="carta-noticia">
            <div class="imagen-carta" style="background-image: url('imagenes/batalla-kv-2025.avif')"></div>
            <div class="contenido-carta">
              <p class="categoria">Música</p>
              <h3>
                Los mejores MCs argentinos se reúnen para coronar al Campeón
                Nacional en un año de celebración de los 20 años de rimas.
                ¿Quién representará al país en la Final Internacional de 2026?
              </h3>
              <a href="eventosYdeportes.php" class="boton-leer-mas-noticia">Leer más</a>
            </div>
          </article>

          <!-- Noticia 3 -->
          <article class="carta-noticia">
            <div class="imagen-carta" style="
                  background-image: url('imagenes/assassins-creed-shadows-leap-of-faith.avif');
                "></div>
            <div class="contenido-carta">
              <p class="categoria">Juegos</p>
              <h3>
                Guía de Assassin's Creed Sombras: Los mejores consejos para
                empezar La serie se reinventa una vez más y ofrece un soplo de
                aire fresco con la ambientación japonesa.
              </h3>
              <a href="eventosYdeportes.php" class="boton-leer-mas-noticia">Leer más</a>
            </div>
          </article>
        </div>
      </div>
    </section>

    <!-- Fin noticias   -->

    <!-- MODAL DE DETALLE DE PRODUCTO -->
    <div id="modal-detalle" class="modal oculto">
      <div class="modal-producto">
        <span class="cerrar" onclick="cerrarModal()">&times;</span>

        <div class="modal-izq">
          <div class="galeria-miniaturas" id="miniaturas"></div>
          <img id="modal-imagen" class="imagen-grande" src="" alt="Imagen principal del producto" />
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
      <button id="boton-finalizar" class="boton-finalizar oculto" onclick="finalizarCompra()">
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

  <!-- Overlay oscuro -->

  <div id="overlay-login" class="overlay oculto"></div>

  <!-- Modal de Login -->

  <?php include 'login.php'; ?>

  <!--Fin Modal de inicio de sesion/registro   -->



  <!-- Aviso emergente en trabajo  -->

  <div id="aviso-trabajo" class="aviso-trabajo oculto">
    🔧 Esta sección está en desarrollo. ¡Pronto estará disponible!
  </div>

  <!-- fin Aviso emergente en trabajo  -->

  <!-- GSAP -->
  <script defer src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
  <!-- ScrollTrigger (para animar con el scroll) -->
  <script defer src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

  <!--  scripts -->
  <script defer src="js/global.js"></script>
  <script defer src="js/modal-carrito.js"></script>
  <script defer src="js/gsap-nav.js"></script>
  <script defer src="js/login.js"></script>
  <script defer src="js/gsap-index.js"></script>
  <script defer src="js/login-error.js"></script>
</body>

</html>