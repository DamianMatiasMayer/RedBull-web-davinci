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
    <title>Perfil de usuario</title>
  </head>

  <body>
    <!-- Header -->
    <header>
      <?php include 'nav.php'; ?>
    </header>
    <!-- Fin Header -->

    <main>
      <div class="registro-page">
        <div class="registro-box">
          <h2>Perfil de usuario</h2>

          <?php if (isset($_SESSION['msg'])): ?>
            <div class="mensaje-sistema">
              <?= htmlspecialchars($_SESSION['msg'], ENT_QUOTES, 'UTF-8') ?>
            </div>
            <?php unset($_SESSION['msg']); ?>
          <?php endif; ?>

          <form action="changePass.php" method="post" class="form-login form-registro">
            <label for="old_pass">Contraseña actual</label>
            <input
              id="old_pass"
              type="password"
              name="old_pass"
              required
              placeholder="Contraseña actual"
            />

            <label for="pswd">Nueva contraseña</label>
            <input
              id="pswd"
              type="password"
              name="pswd"
              required
              placeholder="Nueva contraseña"
            />
        <!-- 
            <label for="confirm-pass">Repetir nueva contraseña</label>
            <input
              id="confirm-pass"
              type="password"
              name="new_pass2"
              required
              placeholder="Repetir nueva contraseña"
            />
            -->
            <button type="submit" class="btn-registrarse">Modificar contraseña</button>
          </form>

          <form action="logout.php" method="post" style="margin-top: 20px;">
            <button type="submit" class="btn-registrarse">Cerrar sesión</button>
          </form>
        </div>
      </div>
    </main>

    <!-- Overlay oscuro -->
    <div id="overlay-login" class="overlay oculto"></div>

    <!-- Modal de Login -->
    <div id="modal-login" class="modal-login oculto">
      <div class="modal-contenido">
        <button class="cerrar-modal" onclick="cerrarModalLogin()">&times;</button>
        <div class="modal-logo">
          <img
            src="imagenes/redbullcom-logo_double-with-text.svg"
            alt="Red Bull Logo"
          />
        </div>
        <form action="login.php" method="post" class="form-login">
          <label for="email">Email</label>
          <input id="email" type="email" name="email" required placeholder="tu@email.com" />

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
    <!-- Fin Modal -->

  <!-- Inicio Footer -->

    <?php
        include 'footer.php';
    ?>

  <!-- Fin Footer -->

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


  <!-- Scritps -->


  <script defer src="js/global.js"></script>
  <script defer src="js/gsap-nav.js"></script>
  <script defer src="js/login.js"></script>

  </body>
</html>
