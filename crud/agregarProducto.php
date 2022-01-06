<?php
error_reporting(0);
$ruta = "../";
include_once("{$ruta}inc/components/cnx.php");

$msgGeneral = '';
$validacion = true;

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
        $sqlInsert = "INSERT INTO productos (descripcion, precio, img, destacado, id_categoria, id_marca) VALUES (?, ?, ?, ?, ?, ?)";
        $psInsert = $cnx->prepare($sqlInsert);
        $psInsert->execute(array($descripcion, $precio, $imagen, $destacado, $categoria, $marca));

        if ($psInsert->rowCount()) {
            $msgGeneral = '<div class="alert-crud crud-insert"><div class="cerrar-alerta"><a href="agregarProducto.php" ><img src="../inc/img/cerrar-sesion.png" /></a></div><p>El producto fue agregado correctamente</p></div>';
            $descripcion = '';
            $precio = '';
            $imagen = '';
            $marca = '';
            $categoria = '';
            $destacado = '';
        } else {
            $msgGeneral = '<div class="alert-crud crud-delete"><p>El producto no fue agregado, intentalo nuevamente</p></div>';
        }
    }
}

// OBTENER PRODUCTOS
$sqlProductos = "SELECT p.codigo, p.descripcion, p.precio, p.img, p.destacado, m.nombre AS nombreMarca, c.nombre AS nombreCategoria
    FROM productos p
    INNER JOIN marcas m ON m.id = p.id_marca
    INNER JOIN categorias c ON c.id = p.id_categoria
    ORDER BY p.codigo desc;";
$ps = $cnx->prepare($sqlProductos);
$ps->execute();
$resProductos = $ps->fetchAll();


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

include("{$ruta}inc/components/header.php");
?>

<!-- PORTADA CRUD -->
<nav id="nav">
    <h2>CRUD PRODUCTOS</h2>
</nav>

<div>
    <?php echo $msgGeneral; ?>
</div>

<!-- FORMULARIO AGREGAR PRODUCTO -->
<div id="contentProducto">
    <form action="agregarProducto.php" method="POST">

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
            <select id="marca" name="marca">

                <option value="0">Seleccionar marca</option>

                <?php foreach ($resMarcas as $dataMarca) { ?>

                    <option value="<?php echo $dataMarca['id']; ?>" <?php if ($marca == $dataMarca['id']) {
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
            <select id="categoria" name="categoria">
                <option value="0">Seleccionar categoria</option>
                <?php foreach ($resCategorias as $dataCategoria) { ?>

                    <option value="<?php echo $dataCategoria['id']; ?>" <?php if ($categoria == $dataCategoria['id']) {
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
            <button type="submit">Agregar producto</button>
        </div>
    </form>
</div>

<!-- TABLA PRODUCTOS -->
<div id="tablaProductos">
    <table>
        <caption>
            Mis productos
        </caption>
        <thead>
            <tr>
                <th>Código</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Imagen</th>
                <th>Destacado</th>
                <th>Marca</th>
                <th>Categoria</th>
                <th>Modificar</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody id="registroProductos">
            <?php
            foreach ($resProductos as $producto) {
            ?>
                <tr>
                    <td><?php echo $producto['codigo'] ?></td>
                    <td><?php echo $producto['descripcion'] ?></td>
                    <td><?php echo $producto['precio'] ?></td>
                    <td><?php echo $producto['codigo'] ?></td>
                    <td>
                        <?php
                        if ($producto['destacado']) {
                            echo 'Si';
                        } else {
                            echo 'No';
                        }
                        ?>
                    </td>
                    <td><?php echo $producto['nombreMarca'] ?></td>
                    <td><?php echo $producto['nombreCategoria'] ?></td>
                    <td class="botonModificar"><a href="modificarProducto.php?codigoProducto=<?php echo $producto['codigo']; ?>&x=">Modificar</a></td>
                    <td class="botonEliminar"><a href="eliminarProducto.php?codigoProducto=<?php echo $producto['codigo']; ?>&x=">Eliminar</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include("{$ruta}inc/components/footer.php") ?>