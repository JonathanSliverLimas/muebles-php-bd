<?php 

    session_start();

        if(isset($_SESSION['nombre']) && isset($_SESSION['apellido_paterno'])){
            session_destroy();
        }

    header('Location: login.php');

?>