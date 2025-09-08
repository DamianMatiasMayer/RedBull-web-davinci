<?php
    //obtener los datos del formulario
    //leyendo los valores enviados por el formulario mediante método POST.
    
    $nombre = $_POST["nombre"];
    $mail = $_POST["email"];
    $pass = $_POST["password"];
    $pass2 = $_POST["confirm-password"];
    
    //$nombre, $mail, $pass, $pass2 guardan lo que el usuario escribió en los inputs name="nombre", name="email", name="password" y name="confirm-password".
  
    //conectar a la base de datos
    //servidor, usuario, contraseña, base de datos
    $conexion = mysqli_connect("localhost", "root", "", "redbull-web");

    //insertar los datos en la tabla usuarios
    //nombre, mail, contraseña, activo, admin
    $query = "INSERT INTO usuarios(nombre, mail, contraseña, activo, admin)
    VALUES ('$nombre', '$mail', '$pass', 1, 0)";

    //ejecutar la consulta, Esto envía la consulta SQL a la base de datos, Si no hay errores, se inserta un nuevo registro en la tabla usuarios.
    mysqli_query($conexion, $query);

    //cerrar la conexión
    mysqli_close($conexion);

    //redireccionar a la página de inicio 
    header('Location: index.html');

    



    //El código recibe los datos del formulario (nombre, email, password, confirm-password), los guarda en variables,
    //se conecta a la base de datos MySQL, inserta un nuevo registro en la tabla usuarios con esos datos, cierra la conexión
    //y finalmente redirige al usuario a la página index.html.
?>

