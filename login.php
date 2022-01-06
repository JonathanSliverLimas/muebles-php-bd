<?php
error_reporting(0);
$ruta = "";
include_once("{$ruta}inc/components/cnx.php");

$msgGeneral = '';
$validacion = true;


if ($_POST['enviado']) {
    $nickname = $_POST["nickname"];
    $password = $_POST["password"];

    if (!$nickname || $nickname == "") {
        $alertNickname = "<span class='alert-form'>El nickname es obligatorio</span>";
        $validacion = false;
    }

    if (!$password || $password == "") {
        $alertPassword = "<span class='alert-form'>La contraseña es obligatoria</span>";
        $validacion = false;
    }

    if ($validacion) {
        $sql = "SELECT * FROM usuarios WHERE nickname = '$nickname';";
        $ps = $cnx->prepare($sql);
        $ps->execute();
        $resUsuario = $ps->fetchAll();

        if ($resUsuario[0]['nickname'] == $nickname && $resUsuario[0]['password'] == $password) {
            $msgGeneral = 'Estas dentro';
            session_start();
            $_SESSION['nombre'] = $resUsuario[0]['nombre'];
            $_SESSION['apellido_paterno'] = $resUsuario[0]['apellido_paterno'];
            header('Location: crud/agregarProducto.php');

        } else if ($resUsuario[0]['nickname'] != $nickname) {
            $msgGeneral = '<div class="alert-crud crud-delete"><div class="cerrar-alerta"><a href="login.php" ><img src="inc/img/cerrar-sesion.png" /></a></div><p>El usuario no existe, intentalo nuevamente</p></div>';
        } else if ($resUsuario[0]['password'] != $password) {
            $msgGeneral = '<div class="alert-crud crud-delete"><div class="cerrar-alerta"><a href="login.php" ><img src="inc/img/cerrar-sesion.png" /></a></div><p>Contraseña incorrecta, intentalo nuevamente</p></div>';
        }

        if(!$resUsuario){
            $msgGeneral = '<div class="alert-crud crud-delete"><div class="cerrar-alerta"><a href="login.php" ><img src="inc/img/cerrar-sesion.png" /></a></div><p>El usuario no existe, intentalo nuevamente</p></div>';
        }
    }
}

include("{$ruta}inc/components/header.php");
?>

<nav id="nav">
    <h2>LOGIN</h2>
</nav>

<div>
    <?php echo $msgGeneral; ?>
</div>

<div id="contentLogin">
    <form action="login.php" method="POST">
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

        <div class="item-btn">
            <input type="hidden" name="enviado" id="enviado" value="1">
            <button type="submit">Iniciar sesion</button>
        </div>
    </form>
</div>

<?php include("{$ruta}inc/components/footer.php"); ?>