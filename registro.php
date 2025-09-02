<?php

    $nombre = $_POST["nombre"];
    $mail = $_POST["email"];
    $pass = $_POST["password"];
    $pass2 = $_POST["confirm-password"];

    //echo "se recibieron los datos: nombre: " . $nombre . ", email: " . $mail . ", password " . $pass;       

    $conexion = mysqli_connect("localhost", "root", "", "redbull-web");


    $query = "INSERT INTO usuarios(nombre, mail, contraseña, activo, admin)
    VALUES ('$nombre', '$mail', '$pass', 1, 0)";

    mysqli_query($conexion, $query);

    mysqli_close($conexion);

    header('Location: index.html');

?>