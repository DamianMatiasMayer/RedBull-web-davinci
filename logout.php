<?php  

    //Iniciar la sesión
    session_start();

    //Destruir la sesión completa, Borra todas las variables de sesión  $_SESSION['usuario'] $_SESSION['tipo_usuario']
    session_destroy();

    header('location: index.php')
?>



