<?php
error_reporting(0);
$ruta = "../";
include_once("{$ruta}inc/components/cnx.php");

$msgGeneral = '';
$codigo = $_POST['codigoProducto'] ? $_POST['codigoProducto'] : $_GET['codigoProducto'];

if($_POST['enviado']){
    $sqlDelete = "DELETE FROM productos WHERE codigo = $codigo";
    $psDelete = $cnx->prepare($sqlDelete);
    $psDelete->execute();
    $msgGeneral = '<div class="alert-crud crud-delete"><p>El producto fue eliminado correctamente</p></p><h5><a href="agregarProducto.php">Volver</a></h5></p></div></div>';
}

$sqlProducto = "SELECT p.codigo, p.descripcion, p.precio, p.destacado, p.img, m.nombre AS nombreMarca, c.nombre AS nombreCategoria  
FROM productos p
INNER JOIN marcas m ON m.id = p.id_marca
INNER JOIN categorias c ON c.id = p.id_categoria
WHERE codigo = $codigo;";
$ps = $cnx->prepare($sqlProducto);
$ps->execute();
$resProductos = $ps->fetchAll();

include("{$ruta}inc/components/header.php");
?>

<!-- PORTADA ELIMINAR -->
<nav id="nav">
   <h2>ELIMINAR PRODUCTO</h2>
</nav>

<!-- ELIMINAR PRODUCTO -->
<div id="contentProducto">
    <?php 
        echo $msgGeneral;
    ?>

    <form action="eliminarProducto.php" method="POST">
        <?php
        if ($resProductos){
            foreach ($resProductos as $producto) {
        ?>
            <div class="item-img">
                <div>
                    <img src="<?php echo $producto['img']; ?>" 
                            alt="No encontramos la imagen :c">
                </div>
            </div>

            <div class="item-form">
                <label id="lblImagen" for="codigo">Codigo</label><br />
                <input  type="text" 
                        name="codigo" id="codigo" 
                        value="<?php echo $producto['codigo']; ?>" 
                        disabled /><br />
            </div>

            <div class="item-form">
                <label id="lblDescripcion" for="descripcion">Descripcion</label><br />
                <input type="text" 
                        name="descripcion" 
                        id="descripcion" 
                        value="<?php echo $producto['descripcion']; ?>"
                        disabled /><br />
            </div>

            <div class="item-form">
                <label id="lblPrecio" for="precio">Precio</label><br />
                <input type="number" 
                        name="precio" 
                        id="precio" 
                        value="<?php echo $producto['precio']; ?>"
                        disabled /><br />
            </div>

            <div class="item-form">
                <label id="lblMarca" for="marca">Marca</label><br />
                <input type="text" 
                        name="marca" 
                        id="marca" 
                        value="<?php echo $producto['nombreMarca']; ?>"
                        disabled /><br />

            </div>

            <div class="item-form">
                <label id="lblCategoria" for="categoria">Categoria</label><br />
                <input type="text" 
                        name="categoria" 
                        id="categoria" 
                        value="<?php echo $producto['nombreCategoria']; ?>"
                        disabled /><br />

            </div>

            <div class="item-form">
                <label id="lblCategoria" for="destacado">Destacado</label><br />
                <input type="text" 
                        name="destacado" 
                        id="destacado" 
                        value="<?php 
                        if ($producto['destacado']){
                            echo 'Si';
                        }else{
                            echo 'No';
                        } ?>"
                        disabled /><br />
            </div>

            <div class="item-btn">
                <input type="hidden" name="enviado" id="enviado" value="1">
                <input type="hidden" name="codigoProducto" id="codigoProducto" value="<?php echo $producto['codigo']; ?>">
                <button type="submit" <?php echo $botonEliminar; ?>>Eliminar producto</button>
            </div>
        <?php }} ?>
    </form>
</div>
<?php include("{$ruta}inc/components/footer.php") ?>