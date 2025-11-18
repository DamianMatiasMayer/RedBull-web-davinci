<?php
@session_start();

//para evitar acceso sin login
if (!isset($_SESSION['usuario'])) {
  header('Location: login.php');
  exit;
}

require 'db_conn.php';

// Solo aceptar POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  $_SESSION['msg'] = 'Método inválido.';
  header('Location: profile.php');
  exit;
}

// Datos del form
$old_pass = trim($_POST['old_pass'] ?? '');
$new_pass = trim($_POST['pswd'] ?? '');
$new_pass2 = trim($_POST['new_pass2'] ?? '');



// Validaciones mínimas
$errores = [];
if ($old_pass === '' || $new_pass === '') {
  $errores[] = 'Faltan datos obligatorios.';
}
if (strlen($new_pass) < 8) {
  $errores[] = 'La nueva contraseña debe tener al menos 8 caracteres.';
}
if ($new_pass !== $new_pass2) {
  $errores[] = 'Las contraseñas nuevas no coinciden.';
}
if ($errores) {
  $_SESSION['msg'] = implode(' ', $errores);
  header('Location: profile.php');
  exit;
}

// agarramos el NOMBRE guardado en sesión 
$nombreSesion = $_SESSION['usuario'];

// Buscar usuario por nombre + contraseña actual 

$sql = "SELECT id FROM usuarios WHERE nombre = ? AND `contraseña` = ? LIMIT 1";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ss", $nombreSesion, $old_pass);
$stmt->execute();
$res = $stmt->get_result();
$user = $res->fetch_assoc();
$stmt->close();

if (!$user) {
  $_SESSION['msg'] = 'La contraseña actual es incorrecta o el usuario no existe.';  // No coincide nombre+contraseña actual => usuario no encontrado o pass incorrecta
  header('Location: profile.php');
  exit;
}
$user_id = (int)$user['id'];


$update = "UPDATE usuarios SET `contraseña` = ? WHERE id = ? LIMIT 1";
$stmt2 = $conexion->prepare($update);
$stmt2->bind_param("si", $new_pass, $user_id);
$ok = $stmt2->execute();
$stmt2->close();

if ($ok) {
  session_regenerate_id(true);
  $_SESSION['msg'] = 'Contraseña actualizada correctamente.';
} else {
  $_SESSION['msg'] = 'No se pudo actualizar la contraseña.';
}

header('Location: profile.php');
exit;