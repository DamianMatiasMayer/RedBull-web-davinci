<?php
require 'db_conn.php';

$arr = explode("/", $_SERVER['HTTP_REFERER']);

function generateInvitation($largo){
  $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!"-$%&/()=?¿';
  return substr(str_shuffle($chars), 0, $largo);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
    $scope  = $_POST['scope'] ?? 'usuario';
    $nombre = $_POST['nombre'] ?? '';
    $mail   = $_POST['email'] ?? '';
    $pass   = $_POST['password'] ?? '';
    $pass2  = $_POST['confirm-password'] ?? '';


  switch ($scope) {

    case 'usuario':
      
      $contraseña = generateInvitation(10);
      $invitacion = generateInvitation(50);
      $query = "INSERT INTO usuarios (nombre, mail, contraseña, activo, tipo_user, invitacion)
                VALUES ('$nombre', '$mail', '$contraseña', 1, 0, '$invitacion')";
      break;

    case 'admin':
      $query = "INSERT INTO usuarios (nombre, mail, contraseña, activo, tipo_user)
                VALUES ('$nombre', '$mail', '$pass', 1, 1)";
      break;

    case 'sysadmin':
      $query = "INSERT INTO usuarios (nombre, mail, contraseña, activo, tipo_user)
                VALUES ('$nombre', '$mail', '$pass', 1, 2)";
      break;
  }

  
  mysqli_query($conexion, $query);
 

  mysqli_close($conexion);

  session_start();

  $link = "http://localhost/redbull-web/RedBull-web-davinci/registro.php?invitacion=" . $invitacion;
  
  $_SESSION['data'] = ['invitacion' => $link];
  
  
  header('Location: ' . $arr[count($arr)-1]);

  

  
  
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

    <div class="rb-topbar">
      <h1 class="rb-title">Administrador de Productos</h1>
      <?php if (isset($_GET['msg'])): ?>
        <p class="rb-flash <?= $_GET['msg']==='error' ? 'rb-flash--error':'rb-flash--ok' ?>">
          <?= htmlspecialchars($_GET['msg']) ?>
        </p>
      <?php endif; ?>
      <button type="button" class="rb-btn rb-btn--primary" onclick="openModal('modalCreate')">
        Nueva Categoría
      </button>
    </div>

  </main>
      

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
    <script defer src="js/global.js"></script>
    <script defer src="js/modal-carrito.js"></script>
    <script defer src="js/gsap-nav.js"></script>
    <script defer src="js/login.js"></script>
    <script defer src="js/gsap-registro.js"></script>
  </body>
</html>
