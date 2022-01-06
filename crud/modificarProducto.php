<?php
error_reporting(0);
$ruta = "../";
include_once("{$ruta}inc/components/cnx.php");

$msgGeneral = '';
$validacion = true;
$codigo = $_POST['codigoProducto'] ? $_POST['codigoProducto'] : $_GET['codigoProducto'];
$ocultarFormulario = false;

// AGREGAR PRODUCTO
if ($_POST['enviado']) {
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    $imagen = $_POST["imagen"];
    $marca = $_POST["marca"];
    $categoria = $_POST["categoria"];
    $destacado = $_POST["destacado"];


    if (!$descripcion && $descripcion == "") {
        $alertDescripcion = "<span class='alert-form'>La descripción es obligatoria</span>";
        $validacion = false;
    }

    if (!$precio && $precio == null) {
        $alertPrecio = "<span class='alert-form'>El precio es obligatorio</span>";
        $validacion = false;
    }

    if (!$imagen && $imagen == "") {
        $alertImg = "<span class='alert-form'>Link de imagen es obligatoria</span>";
        $validacion = false;
    }

    if (!$marca || $marca == 0) {
        $alertMarca = "<span class='alert-form'>La marca es obligatoria</span>";
        $validacion = false;
    }

    if (!$categoria || $categoria == 0) {
        $alertCategoria = "<span class='alert-form'>La categoria es obligatoria</span>";
        $validacion = false;
    }

    if ($validacion) {
        $sqlUpdate = "UPDATE productos SET descripcion = ?, precio = ?, img = ?, destacado = ?, id_categoria = ?, id_marca = ? WHERE codigo = ?";
        $psUpdate = $cnx->prepare($sqlUpdate);
        $psUpdate->execute(array($descripcion, $precio, $imagen, $destacado, $categoria, $marca, $codigo));

        if ($psUpdate->rowCount()) {
            $msgGeneral = '<div class="alert-crud crud-update"><p>El producto fue modificado correctamente</p><p><h5><a href="agregarProducto.php">Volver</a></h5></p></div>';
            $ocultarFormulario = true;
        } else {
            $arr = $psUpdate->errorInfo();
            $msgGeneral = '<div class="alert-crud crud-delete"><p>El producto no fue modificado, intentalo nuevamente. Modifica por lo menos un atributo. Detalle: ' . $arr[2] . '</p></div>';
        }
    }
}

//OBTENER MARCAS
$sqlMarcas = "SELECT * FROM marcas;";
$ps = $cnx->prepare($sqlMarcas);
$ps->execute();
$resMarcas = $ps->fetchAll();


// OBTENER CATEGORIAS
$sqlCategorias = "SELECT * FROM categorias;";
$ps = $cnx->prepare($sqlCategorias);
$ps->execute();
$resCategorias = $ps->fetchAll();

// OBTENER PRODUCTO
$sqlProducto = "SELECT p.codigo, p.descripcion, p.precio, p.destacado, p.img, p.id_categoria, p.id_marca, m.nombre AS nombreMarca, c.nombre AS nombreCategoria  
FROM productos p
INNER JOIN marcas m ON m.id = p.id_marca
INNER JOIN categorias c ON c.id = p.id_categoria
WHERE codigo = $codigo;";
$ps = $cnx->prepare($sqlProducto);
$ps->execute();
$resProductos = $ps->fetchAll();
$cnx = null;
include("{$ruta}inc/components/header.php");
?>

<!-- PORTADA MODIFICAR -->
<nav id="nav">
    <h2>MODIFICAR PRODUCTO</h2>
</nav>

<div>
    <?php echo $msgGeneral; ?>
</div>

<!-- FORMULARIO MODIFICAR PRODUCTO -->
<?php if (!$ocultarFormulario) { ?>
    <div id="contentProducto">
        <form action="modificarProducto.php" method="POST">

            <?php
            if ($resProductos) {
                foreach ($resProductos as $producto) {
                    $descripcion = $producto['descripcion'];
                    $precio = $producto['precio'];
                    $imagen = $producto['img'];
                    $marca = $producto['id_marca'];
                    $categoria = $producto['id_categoria'];
                    $destacado = $producto['destacado'];
            ?>

                    <div class="item-img">
                        <div>
                            <img src="<?php echo $producto['img']; ?>" alt="No encontramos la imagen :c">
                        </div>
                    </div>
                    
                    <div class="item-form">
                        <label id="lblDescripcion" for="descripcion">Descripcion</label><br />
                        <input type="text" name="descripcion" id="descripcion" value="<?php echo $descripcion; ?>" /><br />
                        <?php echo $alertDescripcion; ?>
                    </div>

                    <div class="item-form">
                        <label id="lblPrecio" for="precio">Precio</label><br />
                        <input type="number" name="precio" id="precio" value="<?php echo $precio; ?>" /><br />
                        <?php echo $alertPrecio; ?>
                    </div>

                    <div class="item-form">
                        <label id="lblImagen" for="imagen">Link de la imagen</label><br />
                        <input type="text" name="imagen" id="imagen" value="<?php echo $imagen; ?>" /><br />
                        <?php echo $alertImg; ?>
                    </div>

                    <div class="item-form">
                        <label id="lblMarca" for="marca">Marca</label><br />
                        <select id="marca" name="marca" value="<?php echo 2; ?>">

                            <option value="0">Seleccionar marca</option>

                            <?php foreach ($resMarcas as $dataMarca) { ?>

                                <option value="<?php echo $dataMarca['id']; ?>" 
                                <?php if ($marca == $dataMarca['id']) {
                                    echo 'selected';
                                } ?>>
                                <?php echo $dataMarca['nombre']; ?>
                                </option>

                            <?php } ?>

                        </select><br>
                        <?php echo $alertMarca; ?>
                    </div>

                    <div class="item-form">
                        <label id="lblCategoria" for="categoria">Categoria</label><br />
                        <select id="categoria" name="categoria" value="<?php echo 1; ?>">
                            <option value="0">Seleccionar categoria</option>
                            
                            <?php foreach ($resCategorias as $dataCategoria) { ?>

                                <option value="<?php echo $dataCategoria['id']; ?>" 
                                <?php if ($categoria == $dataCategoria['id']) {
                                    echo 'selected';
                                } ?>>
                                <?php echo $dataCategoria['nombre']; ?>
                                </option>

                            <?php } ?>

                        </select><br>
                        <?php echo $alertCategoria; ?>
                    </div>

                    <div class="item-form">
                        <label id="lblCategoria" for="destacado">Destacado</label><br />
                        <select id="destacado" name="destacado" value="<?php echo $destacado; ?>">
                            <option value="0" <?php if (!$destacado) {
                                                    echo 'selected';
                                                } ?>>No</option>
                            <option value="1" <?php if ($destacado) {
                                                    echo 'selected';
                                                } ?>>Si</option>
                        </select><br>
                    </div>

                    <div class="item-btn">
                        <input type="hidden" name="enviado" id="enviado" value="1">
                        <input type="hidden" name="codigoProducto" id="codigoProducto" value="<?php echo $producto['codigo']; ?>">
                        <button type="submit">Modificar producto</button>
                    </div>
            <?php }
            } ?>
        </form>
    </div>

<?php } ?>

<?php include("{$ruta}inc/components/footer.php") ?>