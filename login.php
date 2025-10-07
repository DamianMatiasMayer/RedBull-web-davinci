<?php
$activo = 0;

if($_SERVER["REQUEST_METHOD"] == "POST"){
    require 'db_conn.php';

    $mail = $_POST["email"] ?? '';
    $pass = $_POST["password"] ?? '';

      // echo $mail . " " . $pass;
    $query = "SELECT id, nombre, activo, tipo_user
              FROM usuarios
              WHERE mail = '$mail' AND `contraseña` = '$pass'
              LIMIT 1";

    $resultado = mysqli_query($conexion, $query);

    if ($resultado && mysqli_num_rows($resultado) === 1) {

        $usuario   = mysqli_fetch_assoc($resultado);
        $nombre    = $usuario["nombre"];
        $activo    = (int)$usuario["activo"];
        $tipo_user = $usuario["tipo_user"];

        if ($activo === 1) {
            session_start();
            $_SESSION['usuario']      = $nombre;
            $_SESSION['tipo_usuario'] = $tipo_user;

            
            header("Location: index.php"); 
            exit;
        } else {
            echo "USUARIO INACTIVO";
        }
    } else {
        echo "credenciales invalidas";
    }
}
?>





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