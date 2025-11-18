<?php
@session_start();

require 'db_conn.php';

$tipo_user = $_SESSION['tipo_usuario'] ?? null; // 0 usuario, 1 admin, 2 sysadmin
if (!$tipo_user || !in_array($tipo_user, ['1','2'], true)) {
  header('Location: index.php');
  exit;
}

/* ====== PROCESO DE ACCIONES (POST) ====== */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $accion = $_POST['accion'] ?? '';
  $id     = isset($_POST['id']) ? (int)$_POST['id'] : 0;

  // Validación ID básico (salvo que la acción no lo use)
  if ($accion !== 'algo_que_no_use_id' && $id <= 0) {
    header('Location: usuarios-admin.php?msg=id_invalido');
    exit;
  }

  /* --- DESACTIVAR --- */
  if ($accion === 'desactivar') {
    // Admin 1 solo puede desactivar usuarios tipo 0. Sysadmin 2 cualquiera.
    if ($tipo_user === '1') {
      $sql  = "UPDATE usuarios u
               JOIN (SELECT id, tipo_user FROM usuarios WHERE id = ?) t ON u.id = t.id
               SET u.activo = 0
               WHERE u.id = ? AND t.tipo_user = 0";
      $stmt = $conexion->prepare($sql);
      $stmt->bind_param("ii", $id, $id);
    } else { // '2'
      $sql  = "UPDATE usuarios SET activo = 0 WHERE id = ?";
      $stmt = $conexion->prepare($sql);
      $stmt->bind_param("i", $id);
    }
    $ok = $stmt->execute();
    $stmt->close();
    header('Location: usuarios-admin.php?msg=' . ($ok ? 'desactivado' : 'error_desactivar'));
    exit;
  }

  /* --- REACTIVAR --- */
  if ($accion === 'reactivar') {
    // Admin 1 solo puede reactivar usuarios tipo 0. Sysadmin 2 cualquiera.
    if ($tipo_user === '1') {
      $sql  = "UPDATE usuarios u
               JOIN (SELECT id, tipo_user FROM usuarios WHERE id = ?) t ON u.id = t.id
               SET u.activo = 1
               WHERE u.id = ? AND t.tipo_user = 0";
      $stmt = $conexion->prepare($sql);
      $stmt->bind_param("ii", $id, $id);
    } else { // '2'
      $sql  = "UPDATE usuarios SET activo = 1 WHERE id = ?";
      $stmt = $conexion->prepare($sql);
      $stmt->bind_param("i", $id);
    }
    $ok = $stmt->execute();
    $stmt->close();
    header('Location: usuarios-admin.php?msg=' . ($ok ? 'reactivado' : 'error_reactivar'));
    exit;
  }

  /* --- EDITAR NOMBRE --- */
  if ($accion === 'editar') {
    $nombre = trim($_POST['nombre'] ?? '');

    if ($nombre === '' || mb_strlen($nombre) > 100) {
      header('Location: usuarios-admin.php?msg=nombre_invalido');
      exit;
    }

    if ($tipo_user === '1') {
      $sql  = "UPDATE usuarios u
               JOIN (SELECT id, tipo_user FROM usuarios WHERE id = ?) t ON u.id = t.id
               SET u.nombre = ?
               WHERE u.id = ? AND t.tipo_user = 0";
      $stmt = $conexion->prepare($sql);
      $stmt->bind_param("isi", $id, $nombre, $id);
    } else { // '2'
      $sql  = "UPDATE usuarios SET nombre = ? WHERE id = ?";
      $stmt = $conexion->prepare($sql);
      $stmt->bind_param("si", $nombre, $id);
    }
    $ok = $stmt->execute();
    $stmt->close();
    header('Location: usuarios-admin.php?msg=' . ($ok ? 'editado' : 'error_editar'));
    exit;
  }

  /* --- CAMBIAR CONTRASEÑA --- */
  if ($accion === 'password') {
    $password  = trim($_POST['password']  ?? '');
    $password2 = trim($_POST['password2'] ?? '');

    // Validaciones de contraseña
    if ($password === '' || $password2 === '') {
      header('Location: usuarios-admin.php?msg=pass_invalida');
      exit;
    }

    if (strlen($password) < 8) {
      header('Location: usuarios-admin.php?msg=pass_invalida');
      exit;
    }

    if ($password !== $password2) {
      header('Location: usuarios-admin.php?msg=pass_no_coincide');
      exit;
    }

    if ($tipo_user === '1') {
      $sql  = "UPDATE usuarios u
               JOIN (SELECT id, tipo_user FROM usuarios WHERE id = ?) t ON u.id = t.id
               SET u.`contraseña` = ?
               WHERE u.id = ? AND t.tipo_user = 0";
      $stmt = $conexion->prepare($sql);
      $stmt->bind_param("ssi", $id, $password, $id);
    } else { // '2'
      $sql  = "UPDATE usuarios SET `contraseña` = ? WHERE id = ?";
      $stmt = $conexion->prepare($sql);
      $stmt->bind_param("si", $password, $id);
    }
    $ok = $stmt->execute();
    $stmt->close();
    header('Location: usuarios-admin.php?msg=' . ($ok ? 'pass_cambiada' : 'error_pass'));
    exit;
  }

  // Acción desconocida
  header('Location: usuarios-admin.php?msg=accion_desconocida');
  exit;
}

/* ====== LECTURA PARA PINTAR LA TABLA ====== */
if ($tipo_user == 1) {
  $sql = "SELECT * FROM usuarios WHERE tipo_user = 0";
} elseif ($tipo_user == 2) {
  $sql = "SELECT * FROM usuarios";
} else {
  header('Location: index.php');
  exit;
}

$resultado = $conexion->query($sql);
$usuarios  = $resultado->fetch_all(MYSQLI_ASSOC);

/* ====== MENSAJES PARA LA VISTA ====== */
$codigo_msg  = $_GET['msg'] ?? '';
$mensaje     = '';
$tipo_alerta = ''; // 'exito' o 'error'

switch ($codigo_msg) {
  case 'desactivado':
    $mensaje = 'Usuario desactivado correctamente.';
    $tipo_alerta = 'exito';
    break;

  case 'error_desactivar':
    $mensaje = 'No se pudo desactivar el usuario.';
    $tipo_alerta = 'error';
    break;

  case 'reactivado':
    $mensaje = 'Usuario reactivado correctamente.';
    $tipo_alerta = 'exito';
    break;

  case 'error_reactivar':
    $mensaje = 'No se pudo reactivar el usuario.';
    $tipo_alerta = 'error';
    break;

  case 'nombre_invalido':
    $mensaje = 'El nombre ingresado no es válido.';
    $tipo_alerta = 'error';
    break;

  case 'editado':
    $mensaje = 'Usuario editado correctamente.';
    $tipo_alerta = 'exito';
    break;

  case 'error_editar':
    $mensaje = 'No se pudo editar el usuario.';
    $tipo_alerta = 'error';
    break;

  case 'pass_invalida':
    $mensaje = 'La contraseña es inválida. Debe tener al menos 8 caracteres.';
    $tipo_alerta = 'error';
    break;

  case 'pass_no_coincide':
    $mensaje = 'Las contraseñas nuevas no coinciden.';
    $tipo_alerta = 'error';
    break;

  case 'pass_cambiada':
    $mensaje = 'Contraseña cambiada correctamente.';
    $tipo_alerta = 'exito';
    break;

  case 'error_pass':
    $mensaje = 'No se pudo cambiar la contraseña.';
    $tipo_alerta = 'error';
    break;

  case 'id_invalido':
    $mensaje = 'ID de usuario inválido.';
    $tipo_alerta = 'error';
    break;

  case 'accion_desconocida':
    $mensaje = 'Acción desconocida.';
    $tipo_alerta = 'error';
    break;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/global.css" />
    <link rel="stylesheet" href="css/modal-carrito.css" />
    <link rel="stylesheet" href="css/modal-login.css" />
    <link rel="stylesheet" href="css/usuario-admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="icon" href="imagenes/favicon.redbull.jpg.png" />
    <title>Administrador de usuarios</title>
</head>

<body>

    <!-- inicio header -->
    <header>
        <?php include 'nav.php'; ?>
    </header>
    <!-- fin header -->

    <main>

        <section class="admin-usuarios">
            <div class="encabezado-admin">
                <h2>Administrador de Usuarios</h2>
                <?php if($tipo_user == 2) : ?>
                      <a href="#" class="btn-nuevo" id="abrir-modal-nuevo">Nuevo Sys Admin</a>
                      <a href="#" class="btn-nuevo" id="abrir-modal-admin">Nuevo Administrador</a>
                <?php endif; ?>
                      <a href="#" class="btn-nuevo" id="abrir-modal-usuario">Nuevo Usuario</a>
            </div>

            <?php if (!empty($mensaje)): ?>
              <div class="alerta <?= $tipo_alerta === 'exito' ? 'alerta-exito' : 'alerta-error' ?>">
                <?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?>
              </div>
            <?php endif; ?>

            <table class="tabla-redbull">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Mail</th>
                        <th>Status</th>
                        <th>Tipo de usuario</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($usuarios as $usuario): ?>
                    <tr>
                        <td><?= (int)$usuario['id']?></td>
                        <td><?= htmlspecialchars($usuario['nombre'], ENT_QUOTES, 'UTF-8')?></td>
                        <td><?= htmlspecialchars($usuario['mail'], ENT_QUOTES, 'UTF-8')?></td>
                        <td>
                          <span class="badge <?= (int)$usuario['activo'] === 1 ? 'activo' : 'inactivo' ?>">
                            <?= (int)$usuario['activo'] === 1 ? 'Activo' : 'Inactivo' ?>
                          </span>
                        </td>
                        <td>
                          <?php
                            switch ((int)$usuario['tipo_user']) {
                              case 0: echo 'Usuario'; break;
                              case 1: echo 'Admin'; break;
                              case 2: echo 'SysAdmin'; break;
                              default: echo (int)$usuario['tipo_user'];
                            }
                          ?>
                        </td>
                        <td class="acciones">
                            <?php if ((int)$usuario['activo'] === 1): ?>
                              <!-- Desactivar -->
                              <a href="#"
                                  onclick="imprimirId(<?= (int)$usuario['id']?>, 'desactivar'); return false;"
                                  class="accion desactivar" title="Desactivar">
                                  <i class="fa-solid fa-ban"></i>
                              </a>
                            <?php else: ?>
                              <!-- Reactivar -->
                              <a href="#"
                                  onclick="imprimirId(<?= (int)$usuario['id']?>, 'reactivar'); return false;"
                                  class="accion reactivar" title="Reactivar">
                                  <i class="fa-solid fa-rotate-right"></i>
                              </a>
                            <?php endif; ?>

                            <!-- Editar -->
                            <a href="#"
                                onclick="imprimirId(<?= (int)$usuario['id']?>, 'editar'); return false;"
                                class="accion editar" title="Editar">
                                <i class="fa-solid fa-pen"></i>
                            </a>

                            <!-- Cambiar contraseña -->
                            <a href="#"
                                onclick="imprimirId(<?= (int)$usuario['id']?>, 'password'); return false;"
                                class="accion password" title="Cambiar contraseña">
                                <i class="fa-solid fa-lock"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
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

    <!-- Footer   -->
    <?php include 'footer.php'; ?>
    <!-- Fin Footer   -->


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

    <!-- modal registro -->
    <div id="overlay-nuevo" class="overlay oculto"></div>

    <div id="modal-nuevo" class="modal-login oculto">
      <div class="modal-contenido">
        <button class="cerrar-modal" id="cerrar-modal-nuevo">&times;</button>

        <div class="modal-logo">
          <img src="imagenes/redbullcom-logo_double-with-text.svg" alt="Red Bull Logo">
        </div>

        <form action="registro.php" method="post" class="form-login form-registro">
          <?php include 'newUser_form.php'; ?>
          <button type="submit" class="btn-registrarse">Registrarse</button>
        </form>
      </div>
    </div>

    <!-- ========== MODAL NUEVO SYS ADMIN ========== -->
    <div id="overlay-nuevo-sysadmin" class="overlay oculto"></div>
    <div id="modal-nuevo-sysadmin" class="modal-login oculto">
      <div class="modal-contenido">
        <button class="cerrar-modal" id="cerrar-modal-nuevo-sysadmin">&times;</button>

        <div class="modal-logo">
          <img src="imagenes/redbullcom-logo_double-with-text.svg" alt="Red Bull Logo">
        </div>

        <form action="registro.php" method="post" class="form-login form-registro">
          <?php include 'newUser_form.php'; ?>
          <input type="hidden" name="scope"  value="sysadmin">
          <button type="submit" class="btn-registrarse">Registrarse</button>
        </form>
      </div>
    </div>

    <!-- ========== MODAL NUEVO ADMINISTRADOR ========== -->
    <div id="overlay-nuevo-admin" class="overlay oculto"></div>
    <div id="modal-nuevo-admin" class="modal-login oculto">
      <div class="modal-contenido">
        <button class="cerrar-modal" id="cerrar-modal-nuevo-admin">&times;</button>

        <div class="modal-logo">
          <img src="imagenes/redbullcom-logo_double-with-text.svg" alt="Red Bull Logo">
        </div>

        <form action="registro.php" method="post" class="form-login form-registro">
          <?php include 'newUser_form.php'; ?>
          <input type="hidden" name="scope"  value="admin">
          <button type="submit" class="btn-registrarse">Registrarse</button>
        </form>
      </div>
    </div>

    <!-- ========== MODAL NUEVO USUARIO ========== -->
    <div id="overlay-nuevo-usuario" class="overlay oculto"></div>
    <div id="modal-nuevo-usuario" class="modal-login oculto">
      <div class="modal-contenido">
        <button class="cerrar-modal" id="cerrar-modal-nuevo-usuario">&times;</button>

        <div class="modal-logo">
          <img src="imagenes/redbullcom-logo_double-with-text.svg" alt="Red Bull Logo">
        </div>

        <form action="registro.php" method="post" class="form-login form-registro">
          <?php include 'newUser_form.php'; ?>
          <input type="hidden" name="scope"  value="usuario">
          <button type="submit" class="btn-registrarse">Registrarse</button>
        </form>
      </div>
    </div>

    <!-- ========== MODAL REACTIVAR ========== -->
    <div id="overlay-reactivar" class="overlay oculto"></div>
    <div id="modal-reactivar" class="modal-login oculto">
      <div class="modal-contenido">
        <button class="cerrar-modal" id="cerrar-reactivar">&times;</button>
        <h3>Reactivar usuario</h3>
        <form action="usuarios-admin.php" method="post" class="form-login">
          <input type="hidden" name="accion" value="reactivar">
          <input type="hidden" name="id" id="id-reactivar">
          <p>¿Confirmás reactivar este usuario?</p>
          <button type="submit" class="btn-login">Reactivar</button>
        </form>
      </div>
    </div>

    <!-- ========== MODAL DESACTIVAR ========== -->
    <div id="overlay-desactivar" class="overlay oculto"></div>
    <div id="modal-desactivar" class="modal-login oculto">
      <div class="modal-contenido">
        <button class="cerrar-modal" id="cerrar-desactivar">&times;</button>
        <h3>Desactivar usuario</h3>
        <form action="usuarios-admin.php" method="post" class="form-login">
          <input type="hidden" name="accion" value="desactivar">
          <input type="hidden" name="id" id="id-desactivar">
          <label for="motivo-desactivar">Motivo (opcional)</label>
          <input id="motivo-desactivar" name="motivo" type="text">
          <button type="submit" class="btn-login">Desactivar</button>
        </form>
      </div>
    </div>

    <!-- ========== MODAL EDITAR ========== -->
    <div id="overlay-editar" class="overlay oculto"></div>
    <div id="modal-editar" class="modal-login oculto">
      <div class="modal-contenido">
        <button class="cerrar-modal" id="cerrar-editar">&times;</button>
        <h3>Editar usuario</h3>
        <form action="usuarios-admin.php" method="post" class="form-login">
          <input type="hidden" name="accion" value="editar">
          <input type="hidden" name="id" id="id-editar">
          <label for="nombre-editar">Nuevo nombre</label>
          <input id="nombre-editar" name="nombre" type="text" required>
          <button type="submit" class="btn-login">Guardar</button>
        </form>
      </div>
    </div>

    <!-- ========== MODAL CAMBIAR CONTRASEÑA ========== -->
    <div id="overlay-password" class="overlay oculto"></div>
    <div id="modal-password" class="modal-login oculto">
      <div class="modal-contenido">
        <button class="cerrar-modal" id="cerrar-password">&times;</button>
        <h3>Cambiar contraseña</h3>
        <form action="usuarios-admin.php" method="post" class="form-login">
          <input type="hidden" name="accion" value="password">
          <input type="hidden" name="id" id="id-password">

          <label for="pass-nuevo">Nueva contraseña</label>
          <input id="pass-nuevo" name="password" type="password" required>

          <label for="pass-nuevo2">Repetir nueva contraseña</label>
          <input id="pass-nuevo2" name="password2" type="password" required>

          <button type="submit" class="btn-login">Cambiar</button>
        </form>
      </div>
    </div>

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
    <script defer src="js/modal-nuevo.js?v=<?= filemtime('js/modal-nuevo.js') ?>"></script>
    <script defer src="js/modales-usuarios.js"></script>

</body>
</html>
