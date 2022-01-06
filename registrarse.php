<?php
error_reporting(0);
$ruta = "";
include_once("{$ruta}inc/components/cnx.php");

$msgGeneral = '';
$validacion = true;

// REGISTRO DE USUARIO
if ($_POST['enviado']) {
    $nickname = $_POST["nickname"];
    $password = $_POST["password"];
    $confirmar_password = $_POST["confirmar_password"];
    $nombre = $_POST["nombre"];
    $apellido_paterno = $_POST["apellido_paterno"];
    $apellido_materno = $_POST["apellido_materno"];

    if (!$nickname || $nickname == "") {
        $alertNickname = "<span class='alert-form'>El nickname es obligatorio</span>";
        $validacion = false;
    }

    if (!$password || $password == "") {
        $alertPassword = "<span class='alert-form'>La contraseña es obligatoria</span>";
        $validacion = false;
    }

    if (!$confirmar_password || $confirmar_password == "") {
        $alertConfirmarPassword = "<span class='alert-form'>Confirmar la contraseña es obligatorio</span>";
        $validacion = false;
    }else if($confirmar_password != $password){
        $alertConfirmarPassword = "<span class='alert-form'>Las contraseñas no coinciden</span>";
        $validacion = false;
    }

    if (!$nombre || $nombre == "") {
        $alertNombre = "<span class='alert-form'>El nombre es obligatorio</span>";
        $validacion = false;
    }

    if (!$apellido_paterno || $apellido_paterno == "") {
        $alertApellidoP = "<span class='alert-form'>El apellido paterno es obligatorio</span>";
        $validacion = false;
    }

    if (!$apellido_materno || $apellido_materno == "") {
        $alertApellidoM = "<span class='alert-form'>El apellido materno es obligatorio</span>";
        $validacion = false;
    }

    if ($validacion) {
        $sqlInsert = "INSERT INTO usuarios (`nickname`, `password`, `nombre`, `apellido_paterno`, `apellido_materno`) VALUES (?, ?, ?, ?, ?)";
        $psInsert = $cnx->prepare($sqlInsert);
        $psInsert->execute(array($nickname, $password, $nombre, $apellido_paterno, $apellido_materno));

        if ($psInsert->rowCount()) {
            $nickname = '';
            $password = '';
            $confirmar_password = '';
            $nombre = '';
            $apellido_paterno = '';
            $apellido_materno = '';
            $msgGeneral = '<div class="alert-crud crud-insert"><div class="cerrar-alerta"><a href="registrarse.php" ><img src="inc/img/cerrar-sesion.png" /></a></div><p>Te registraste correctamente.</p><p><h5><a href="login.php">Iniciar sesión</a></h5></p></div>';
        } else {
            $arr = $psInsert->errorInfo();
            $msgGeneral = '<div class="alert-crud crud-delete"><p>El usuario ya existe, intentalo nuevamente. Detalle --> '. $arr[2]. '</p></div>';
        }
    }
}

include("{$ruta}inc/components/header.php");
?>

<nav id="nav">
    <h2>REGISTRARSE</h2>
</nav>
<div>
    <?php echo $msgGeneral; ?>
</div>

<div id="contentRegistro">
    <form action="registrarse.php" method="POST">
        <div class="item-form">
            <label for="nickname">Nickname</label><br />
            <input type="text" name="nickname" id="nickname" value="<?php echo $nickname; ?>" /><br />
            <?php echo $alertNickname; ?>
        </div>

        <div class="item-form">
            <label for="password">Contraseña</label><br />
            <input type="password" name="password" id="password" value="<?php echo $password; ?>" /><br />
            <?php echo $alertPassword; ?>
        </div>

        <div class="item-form">
            <label for="confirmar_password">Confirmar contraseña</label><br />
            <input type="password" name="confirmar_password" id="confirmar_password" value="<?php echo $confirmar_password; ?>" /><br />
            <?php echo $alertConfirmarPassword; ?>
        </div>

        <div class="item-form">
            <label for="password">Nombre</label><br />
            <input type="text" name="nombre" id="nombre" value="<?php echo $nombre; ?>" /><br />
            <?php echo $alertNombre; ?>
        </div>

        <div class="item-form">
            <label for="apellido_paterno">Apellido Paterno</label><br />
            <input type="text" name="apellido_paterno" id="apellido_paterno" value="<?php echo $apellido_paterno; ?>" /><br />
            <?php echo $alertApellidoP ?>
        </div>

        <div class="item-form">
            <label for="apellido_materno">Apellido Materno</label><br />
            <input type="text" name="apellido_materno" id="apellido_materno" value="<?php echo $apellido_materno; ?>" /><br />
            <?php echo $alertApellidoM ?>
        </div>

        <div class="item-btn">
            <input type="hidden" name="enviado" id="enviado" value="1">
            <button type="submit">Registrarme</button>
        </div>
    </form>
</div>

<?php include("{$ruta}inc/components/footer.php"); ?>