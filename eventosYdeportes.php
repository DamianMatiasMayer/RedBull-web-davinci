<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/global.css" />
  <link rel="stylesheet" href="css/eventosYdeportes.css" />
  <link rel="stylesheet" href="css/modal-carrito.css" />
  <link rel="stylesheet" href="css/modal-login.css">
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="icon" href="imagenes/favicon.redbull.jpg.png" />
  <!-- icono pestaña navegador -->
  <title>RedBull Deportes</title>
</head>

<body>
  <!-- inicio header -->

  <header>
    <?php
        include 'nav.php';
    ?>
  </header>

  <!-- fin header -->

  <main>
    <div class="fondo">
      <!-- fondo -->
      <img src="imagenes/white-flag.avif" alt="pista" class="pista" />

      <!-- Autos arriba -->
      <img src="imagenes/auto f1.png" class="auto" id="auto1" />
      <img src="imagenes/auto f1.png" class="auto" id="auto2" />
      <img src="imagenes/auto f1.png" class="auto" id="auto3" />
      <img src="imagenes/auto f1.png" class="auto" id="auto4" />
      <img src="imagenes/auto f1.png" class="auto" id="auto5" />
    </div>

    <!-- titulo de eventos -->
    <div class="contenedor-margenes">
      <h1 class="titulo-eventos">Eventos</h1>

      <p class="descripcion-eventos">
        Sumergite en el mundo de la adrenalina y la competencia. Descubrí los
        proximos eventos deportivos más impactantes patrocinados por Red Bull:
        desde carreras de Fórmula 1 hasta deportes extremos que desafían los
        límites. ¡Viví la emoción como nunca antes!
      </p>

      <hr class="linea-divisoria" />
    </div>

    <!-- seccion de eventos destacados-->
    <section>
      <article>
        <!-- evento 1 -->
        <div class="bloque-imagen-texto contenedor-margenes">
          <img src="imagenes/formula1-arriba.jpeg" alt="Evento Red Bull" class="imagen-lateral" />
          <div class="texto-lateral">
            <h2>Grand Prix 2025 Belgica. Julio 25-27 2025</h2>
            <p>
              Spa está entre las pistas más queridas por los pilotos de
              Fórmula 1, con su mezcla de largas rectas y desafiantes curvas
              rápidas que les permiten llevar sus coches al límite de sus
              capacidades, si es que está seco, claro. El tamaño de la pista y
              la naturaleza del clima belga significa que a veces puede estar
              lloviendo en una parte de la pista y seco en otra, lo que hace
              que la adherencia varíe de una curva a otra. Presta atención a
              la emocionante Eau Rouge, posiblemente la secuencia de curvas
              más famosa del mundo, mientras los pilotos giran a la izquierda,
              a la derecha y luego suben la colina a través de Raidillon.
            </p>
            <img src="imagenes/belgica-grand-prix-2025.avif" alt="Imagen secundaria" class="imagen-secundaria" />
          </div>
        </div>

        <!-- evento 2 -->
        <div class="bloque-freestyle contenedor-margenes">
          <div class="fila-freestyle">
            <!-- Texto a la izquierda -->
            <div class="freestyle-texto">
              <h2>Red Bull Batalla Chile 2025</h2>
              <p>
                ¡Y se la damos en tres, dos, uno! Este 6 de julio, la ciudad
                de Concepción volverá a encender la mecha del freestyle.
                <br />
                La Final Nacional de Red Bull Batalla Chile 2025 reunirá a 16
                MC’s dispuestos a dejarlo todo por un objetivo: coronarse
                campeones y asegurar su lugar en la Final Internacional. Una
                nueva oportunidad para que el rap chileno haga ruido en la
                escena global<br />
                Pero no solo los freestylers serán protagonistas. Porque si
                algo nos ha enseñado la historia de Red Bull Batalla, es que
                una final no se cocina solo con rimas. El fuego también se
                enciende desde la mesa del jurado.<br />
              </p>

              <img src="imagenes/redbull-batalla-logo.avif" alt="Batalla de freestyle"
                class="freestyle-imagen-secundaria" />
            </div>

            <!-- Imagen principal a la derecha -->
            <img src="imagenes/redbull-batalla.avif" alt="Freestyler Red Bull" class="freestyle-imagen-principal" />
          </div>
        </div>

        <!-- evento 3 -->
        <div class="bloque-imagen-texto contenedor-margenes">
          <img src="imagenes/maverick-vinales-red-bull-ktm-dutch-motogp-assen-2025-race-action.avif"
            alt="Evento Red Bull" class="imagen-lateral" />
          <div class="texto-lateral">
            <h2>MotoGP™ Austrian Grand Prix Agosto 15-17 2025</h2>
            <p>
              En la 13ª ronda de MotoGP™ 2025, los pilotos se dirigen al Red
              Bull Ring. El Gran Premio de Austria promete emocionantes duelos
              en la batalla por el campeonato.<br />
              Cuando los mejores pilotos del mundo compiten entre sí en el Red
              Bull Ring, los duelos al límite son inevitables. El Red Bull
              Ring de 4.348 km con sus rectas rápidas y curvas desafiantes
              proporciona el escenario perfecto para un espectáculo de MotoGP™
              de primer nivel.
            </p>
            <img src="imagenes/grand-prix-austria.png" alt="Imagen secundaria" class="imagen-secundaria" />
          </div>
        </div>
      </article>
    </section>
    <!--fin de seccion de eventos destacados-->

    <!-- carrousel eventos -->
    <section>
      <h2 class="titulo-mas-eventos contenedor-margenes">
        Encontrá eventos de tu interés
      </h2>

      <div class="contenedor-eventos">
        <button class="flecha izquierda">‹</button>

        <div class="carrusel-eventos">
          <!-- Tarjeta Wakeboarding -->
          <div class="tarjeta-evento">
            <div class="imagen-contenedor">
              <img src="imagenes/wakeboard-munich.avif" alt="Evento wakeboard" />
            </div>
            <h3>Munich Mash: Final Wakeboarding Hombres</h3>
            <p>Munich 2025</p>
            <p>WAKEBOARD</p>
          </div>

          <!-- Tarjeta Clavadismo -->
          <div class="tarjeta-evento">
            <div class="imagen-contenedor">
              <img src="imagenes/kaylea-arnett.avif" alt="Evento clavadismo" />
            </div>
            <h3>Cliff Diving</h3>
            <p>Red Bull Cliff Diving Series Mundial</p>
            <p>CLAVADISMO</p>
          </div>

          <!-- Tarjeta Drift -->
          <div class="tarjeta-evento">
            <div class="imagen-contenedor">
              <img src="imagenes/red-bull-drift.avif" alt="Evento drift" />
            </div>
            <h3>Drift Masters: Top 16-Irlanda Livestream</h3>
            <p>Drift Masters 2025</p>
            <p>DRIFTING</p>
          </div>

          <!-- Tarjeta BMX1 -->
          <div class="tarjeta-evento">
            <div class="imagen-contenedor">
              <img src="imagenes/munich-mash-bmx.avif" alt="Evento BMX" />
            </div>
            <h3>Munich Mash: BMX Final Hombres</h3>
            <p>Munich Mash 2025</p>
            <p>BMX</p>
          </div>

          <!-- Tarjeta SK8 Hombre -->
          <div class="tarjeta-evento">
            <div class="imagen-contenedor">
              <img src="imagenes/alex-sorgente-skate.avif" alt="Evento skateboarding" />
            </div>
            <h3>Copa Mystic Sk8 Dia 2: Street, Bowl y mejores trucos</h3>
            <p>Copa Mystic Sk8</p>
            <p>SKATEBOARD</p>
          </div>

          <!-- Tarjeta SK8 Mujer -->
          <div class="tarjeta-evento">
            <div class="imagen-contenedor">
              <img src="imagenes/yndiara-asp-skate.avif" alt="Evento skateboarding mujer" />
            </div>
            <h3>Munich Mash: Final Skateboarding Mujeres</h3>
            <p>Munich Mash 2025</p>
            <p>SKATEBOARD</p>
          </div>

          <!-- Tarjeta Surf -->
          <div class="tarjeta-evento">
            <div class="imagen-contenedor">
              <img src="imagenes/italo-ferreira-surfing.avif" alt="Evento surfing" />
            </div>
            <h3>WSL Rio Finales</h3>
            <p>Campeonato WSL Tour 2025</p>
            <p>SURF</p>
          </div>

          <!-- Tarjeta Padel -->
          <div class="tarjeta-evento">
            <div class="imagen-contenedor">
              <img src="imagenes/jeronimo-gonzalez-padel.avif" alt="Evento padel" />
            </div>
            <h3>Final Valladolid</h3>
            <p>Premier Padel 2025</p>
            <p>PÁDEL</p>
          </div>
        </div>

        <button class="flecha derecha">›</button>
      </div>
    </section>
    <!-- fin carrousel eventos -->

    <!-- Deportes -->
    <section>
      <h2 class="titulo-mas-eventos contenedor-margenes">Deportes</h2>

      <div class="contenedor-carrousel">
        <button class="flecha izquierda">‹</button>

        <div class="carrusel-productos">
          <!-- Tarjeta Oracle -->
          <div class="tarjeta-deporte">
            <div class="fondo-oscuro" style="
                  background-image: url('imagenes/formula1-oracle-deporte.avif');
                ">
              <img src="imagenes/RB-logo.png" alt="Logo equipo" class="logo-equipo" />
              <p class="nombre-deporte">Oracle Red Bull Racing</p>
            </div>
          </div>

          <!-- Tarjeta Bora -->
          <div class="tarjeta-deporte">
            <div class="fondo-oscuro" style="background-image: url('imagenes/ciclismo.rb.bora.avif')">
              <img src="imagenes/logo.bora.png" alt="Logo equipo" class="logo-equipo" />
              <p class="nombre-deporte">Red Bull BORA Hansgrohe</p>
            </div>
          </div>

          <!-- Tarjeta EHC -->
          <div class="tarjeta-deporte">
            <div class="fondo-oscuro" style="
                  background-image: url('imagenes/rb.patin.sobre.hielo.avif');
                ">
              <img src="imagenes/rb.logo.patin.sobre.hielo.png" alt="Logo equipo" class="logo-equipo" />
              <p class="nombre-deporte">EHC Red Bull München</p>
            </div>
          </div>

          <!-- Tarjeta Snowboard -->
          <div class="tarjeta-deporte">
            <div class="fondo-oscuro" style="background-image: url('imagenes/redbull.snowboard.avif')">
              <img src="imagenes/redbull.snowboard.logo.png" alt="Logo equipo" class="logo-equipo" />
              <p class="nombre-deporte">Red Bull Snowboard SPECT</p>
            </div>
          </div>

          <!-- Tarjeta Batalla -->
          <div class="tarjeta-deporte">
            <div class="fondo-oscuro" style="background-image: url('imagenes/redbull.batalla.avif')">
              <img src="imagenes/redbull.logo.batalla.png" alt="Logo equipo" class="logo-equipo" />
              <p class="nombre-deporte">Red Bull Batalla</p>
            </div>
          </div>

          <!-- Tarjeta Diving -->
          <div class="tarjeta-deporte">
            <div class="fondo-oscuro" style="
                  background-image: url('imagenes/redbull.clif.diving.avif');
                ">
              <img src="imagenes/cliff.diving. logo.png" alt="Logo equipo" class="logo-equipo" />
              <p class="nombre-deporte">Red Bull Cliff Diving</p>
            </div>
          </div>

          <!-- Tarjeta Rampage -->
          <div class="tarjeta-deporte">
            <div class="fondo-oscuro" style="background-image: url('imagenes/redbull.rampage.avif')">
              <img src="imagenes/redbull.rampage.logo.png" alt="Logo equipo" class="logo-equipo" />
              <p class="nombre-deporte">Red Bull Rampage</p>
            </div>
          </div>

          <!-- Tarjeta Drift Masters -->
          <div class="tarjeta-deporte">
            <div class="fondo-oscuro" style="
                  background-image: url('imagenes/drift-masters-red-bull-race-car.avif');
                ">
              <img src="imagenes/redbull.drift.masters.avif" alt="Logo equipo" class="logo-equipo" />
              <p class="nombre-deporte">Red Bull Drift Masters</p>
            </div>
          </div>

          <!-- Tarjeta Padel -->
          <div class="tarjeta-deporte">
            <div class="fondo-oscuro" style="background-image: url('imagenes/redbull.padel.avif')">
              <img src="imagenes/redbull.padel.logo.avif" alt="Logo equipo" class="logo-equipo" />
              <p class="nombre-deporte">Red Bull Padel</p>
            </div>
          </div>
        </div>

        <button class="flecha derecha">›</button>
      </div>
    </section>

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

  <!-- Footer -->

  <footer>
    <div class="contenido-footer">
      <img src="imagenes/redbullcom-logo_double-with-text.svg" alt="Red Bull Logo" class="footer-logo" />

      <ul class="footer-links">
        <li><a href="productos.html">nuestros productos</a></li>
        <li><a href="#" onclick="mostrarAviso(event)">Empleo</a></li>
        <li><a href="#" onclick="mostrarAviso(event)">Términos</a></li>
        <li>
          <a href="#" onclick="mostrarAviso(event)">Política de privacidad</a>
        </li>
        <li><a href="contacto.html">Contactanos</a></li>
      </ul>

      <div class="footer-redes">
        <a href="#" onclick="mostrarAviso(event)"><img src="imagenes/instagram.png" alt="Instagram" /></a>
        <a href="#" onclick="mostrarAviso(event)"><img src="imagenes/youtube.png" alt="YouTube" /></a>
        <a href="#" onclick="mostrarAviso(event)"><img src="imagenes/facebook.png" alt="Facebook" /></a>
        <a href="#" onclick="mostrarAviso(event)"><img src="imagenes/X.png" alt="X" /></a>
      </div>

      <p class="footer-copy">
        © 2025 Red Bull Argentina. Todos los derechos reservados. Damián Mayer
        Escuela Davinci
      </p>
    </div>
  </footer>

  <!--fin Footer -->

  <!-- Modal de inicio de sesion/registro   -->

  <!-- Overlay oscuro -->
  <div id="overlay-login" class="overlay oculto"></div>

  <!-- Modal de Login -->

  <div id="modal-login" class="modal-login oculto">
    <div class="modal-contenido">
      <button class="cerrar-modal" onclick="cerrarModalLogin()">&times;</button>

      <div class="modal-logo">
        <img src="imagenes/redbullcom-logo_double-with-text.svg" alt="Red Bull Logo">
      </div>
      <form action="login.php" method="post" class="form-login">

        <label for="email">Email</label>
        <input id="email" type="email" name="email" required placeholder="tu@email.com">

        <label for="password">Contraseña</label>
        <div class="campo-password">
          <input id="login-password" type="password" name="password" required placeholder="********">
          <i class="fa-solid fa-eye" id="togglePassword"></i>
        </div>
        <button type="submit" class="btn-login">Ingresar</button>
      </form>


      <p class="modal-footer">
        ¿No tenés cuenta?
        <a href="registro.php">Registrate</a>
      </p>
    </div>
  </div>

  <!--Fin Modal de inicio de sesion/registro   -->

  <!-- Aviso emergente en trabajo  -->

  <div id="aviso-trabajo" class="aviso-trabajo oculto">
    🔧 Esta sección está en desarrollo. ¡Pronto estará disponible!
  </div>

  <!-- GSAP -->
  <script defer src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
  <!-- ScrollTrigger (para animar con el scroll) -->
  <script defer src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

  <!-- Scritps -->
  <script defer src="js/global.js"></script>
  <script defer src="js/eventosYdeportes.js"></script>
  <script defer src="js/modal-carrito.js"></script>
  <script defer src="js/gsap-nav.js"></script>
  <script defer src="js/login.js"></script>
</body>

</html>