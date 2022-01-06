<?php
error_reporting(0);
$ruta = "";
include_once("{$ruta}inc/components/cnx.php");

/* OBTENER PRODUCTOS */
$sql = "SELECT p.descripcion, p.precio, p.img, m.nombre AS nombreMarca, c.nombre AS nombreCategoria
FROM productos p
INNER JOIN marcas m ON m.id = p.id_marca
INNER JOIN categorias c ON c.id = p.id_categoria";

$ps = $cnx->prepare($sql);
$ps->execute();
$resProductos = $ps->fetchAll();

include("{$ruta}inc/components/header.php");
?>

<nav id="nav">
    <h2>PRODUCTOS</h2>
</nav>

<section id="content">


    <!-- BLOQUE ESCRITORIOS -->
    <div id="sectionContainer">
        <div class="tituloEscritorios">
            <h1>Escritorios</h1>
        </div>

        <div id="itemsEscritorios">
            <?php
            foreach ($resProductos as $producto) {
            ?>
                <?php
                if ($producto['nombreCategoria'] == 'escritorio') {
                ?>

                    <article class="articulo">
                        <div class="imgArticle">
                            <img src="<?php echo $producto['img']; ?>" onerror="cargarImgDefecto(this)" />
                        </div>
                        <div class="nombreProducto">
                            <h3><?php echo $producto['nombreMarca']; ?></h3>
                            <h2><?php echo $producto['descripcion']; ?></h2>
                        </div>
                        <div class="precioProducto">
                            <h3>$<?php echo $producto['precio']; ?> C/U</h3>
                        </div>
                    </article>
                <?php } ?>
            <?php } ?>
        </div>
    </div>


    <!-- BLOQUE SILLAS -->
    <div id="sectionContainer">
        <div class="tituloSillas">
            <h1>Sillas PC</h1>
        </div>
        <div id="itemsSillas">
            <?php
            foreach ($resProductos as $producto) {
            ?>
                <?php
                if ($producto['nombreCategoria'] == 'silla') {
                ?>

                    <article class="articulo">
                        <div class="imgArticle">
                            <img src="<?php echo $producto['img']; ?>" onerror="cargarImgDefecto(this)" />
                        </div>
                        <div class="nombreProducto">
                            <h3><?php echo $producto['nombreMarca']; ?></h3>
                            <h2><?php echo $producto['descripcion']; ?></h2>
                        </div>
                        <div class="precioProducto">
                            <h3>$<?php echo $producto['precio']; ?> C/U</h3>
                        </div>
                    </article>
                <?php } ?>
            <?php } ?>
        </div>
    </div>


    <!-- BLOQUE ESTANTES -->
    <div id="sectionContainer">
        <div class="tituloEstantes">
            <h1>Estanterías</h1>
        </div>
        <div id="itemsEstantes">
            <?php
            foreach ($resProductos as $producto) {
            ?>
                <?php
                if ($producto['nombreCategoria'] == 'estante') {
                ?>

                    <article class="articulo">
                        <div class="imgArticle">
                            <img src="<?php echo $producto['img']; ?>" onerror="cargarImgDefecto(this)" />
                        </div>
                        <div class="nombreProducto">
                            <h3><?php echo $producto['nombreMarca']; ?></h3>
                            <h2><?php echo $producto['descripcion']; ?></h2>
                        </div>
                        <div class="precioProducto">
                            <h3>$<?php echo $producto['precio']; ?> C/U</h3>
                        </div>
                    </article>
                <?php } ?>
            <?php } ?>
        </div>
    </div>


</section>


<!-- FOOTER -->
<?php include("{$ruta}inc/components/footer.php"); ?>