<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Muebles Limas</title>
  <link rel="stylesheet" type="text/css" href="<?php echo $ruta; ?>inc/css/style.css?v=<?php echo time(); ?>" />
</head>

<body id="body">
  <header id="header">
    <div class="logo">
      <h5>Muebles Limas</h5>
    </div>
    <div class="menu">
      <a class="navegacion" href="<?php echo $ruta; ?>index.php">Inicio</a>
      <a class="navegacion" href="<?php echo $ruta; ?>productos.php">Productos</a>
      

      <?php if(!isset($_SESSION['nombre'])) { ?>
      <a class="navegacion" href="<?php echo $ruta; ?>login.php">Login</a>
      <a class="navegacion" href="<?php echo $ruta; ?>registrarse.php">Registrarse</a>
      <?php } ?>

      <?php if(isset($_SESSION['nombre'])) { ?>
      <a class="navegacion" href="<?php echo $ruta; ?>crud/agregarProducto.php">Agregar</a>
      <a class="navegacion delete-session" href="<?php echo $ruta; ?>cerrar-sesion.php">Cerrar sesión</a>
      <a class="navegacion start-session"><?php echo $_SESSION['nombre'].' '.$_SESSION['apellido_paterno'] ?></a>
      <?php } ?>

    </div>
  </header>