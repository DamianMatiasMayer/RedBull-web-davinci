<?php


      //conectar a la base de datos
      //servidor, usuario, contraseña, base de datos
  require 'db_conn.php';

  $arr = explode("/", $_SERVER['HTTP_REFERER']);


  if($_SERVER['REQUEST_METHOD'] == 'POST') {

      //obtener los datos del formulario
      //leyendo los valores enviados por el formulario mediante método POST.
      
      $nombre = $_POST["nombre"];
      $mail = $_POST["email"];
      $pass = $_POST["password"];
      $pass2 = $_POST["confirm-password"];
      
      //$nombre, $mail, $pass, $pass2 guardan lo que el usuario escribió en los inputs name="nombre", name="email", name="password" y name="confirm-password".

      //insertar los datos en la tabla usuarios
      //nombre, mail, contraseña, activo, admin
      $query = "INSERT INTO usuarios(nombre, mail, contraseña, activo, admin)
      VALUES ('$nombre', '$mail', '$pass', 1, 0)";

      //ejecutar la consulta, Esto envía la consulta SQL a la base de datos, Si no hay errores, se inserta un nuevo registro en la tabla usuarios.
      mysqli_query($conexion, $query);

      //cerrar la conexión
      mysqli_close($conexion);

      //redireccionar a la página de inicio 
      header('Location: ' . $arr[count($arr)-1]);
      
      //El código recibe los datos del formulario (nombre, email, password, confirm-password), los guarda en variables,
      //se conecta a la base de datos MySQL, inserta un nuevo registro en la tabla usuarios con esos datos, cierra la conexión
      //y finalmente redirige al usuario a la página index.html.

  }

?>







<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/global.css" />
    <link rel="stylesheet" href="css/modal-carrito.css" />
    <link rel="stylesheet" href="css/modal-login.css" />
    <link rel="stylesheet" href="css/registro.css" />
    <link
      href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;700&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
    <link rel="icon" href="imagenes/favicon.redbull.jpg.png" />
    <title>Registro</title>
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
      <div class="registro-page">
        <div class="registro-box">
          <h2>Crear cuenta</h2>

          <?php
            include 'newUser_form.php';
          ?>

          <p class="registro-footer">
            ¿Ya tenés cuenta?
            <a href="#">Iniciá sesión</a>
          </p>
        </div>
      </div>

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

    <footer>
      <div class="contenido-footer">
        <img
          src="imagenes/redbullcom-logo_double-with-text.svg"
          alt="Red Bull Logo"
          class="footer-logo"
        />

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
          <a href="#" onclick="mostrarAviso(event)">
            <img src="imagenes/instagram.png" alt="Instagram"
          /></a>
          <a href="#" onclick="mostrarAviso(event)"
            ><img src="imagenes/youtube.png" alt="YouTube"
          /></a>
          <a href="#" onclick="mostrarAviso(event)"
            ><img src="imagenes/facebook.png" alt="Facebook"
          /></a>
          <a href="#" onclick="mostrarAviso(event)"
            ><img src="imagenes/X.png" alt="X"
          /></a>
        </div>

        <p class="footer-copy">
          © 2025 Red Bull Argentina. Todos los derechos reservados. Damián Mayer
          Escuela Davinci
        </p>
      </div>
    </footer>

    <!-- Fin Footer   -->

    <!-- Modal de inicio de sesion/registro   -->

    <!-- Overlay oscuro -->
    <div id="overlay-login" class="overlay oculto"></div>

    <!-- Modal de Login -->

    <div id="modal-login" class="modal-login oculto">
      <div class="modal-contenido">
        <button class="cerrar-modal" onclick="cerrarModalLogin()">
          &times;
        </button>

        <div class="modal-logo">
          <img
            src="imagenes/redbullcom-logo_double-with-text.svg"
            alt="Red Bull Logo"
          />
        </div>
        <form action="login.php" method="post" class="form-login">
          <label for="email">Email</label>
          <input
            id="email"
            type="email"
            name="email"
            required
            placeholder="tu@email.com"
          />

          <label for="password">Contraseña</label>
          <div class="campo-password">
            <input
              id="login-password"
              type="password"
              name="password"
              required
              placeholder="********"
            />
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

    <!-- fin Aviso emergente en trabajo  -->

    <!-- GSAP -->
    <script
      defer
      src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"
    ></script>
    <!-- ScrollTrigger (para animar con el scroll) -->
    <script
      defer
      src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"
    ></script>

    <!--  scripts -->
    <script defer src="js/registro.js"></script>
    <script defer src="js/mostrar-ocultar.js"></script>
    <script defer src="js/global.js"></script>
    <script defer src="js/modal-carrito.js"></script>
    <script defer src="js/gsap-nav.js"></script>
    <script defer src="js/login.js"></script>
    <script defer src="js/gsap-registro.js"></script>
  </body>
</html>
