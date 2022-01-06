<?php
error_reporting(0);
$ruta = "";
include_once("{$ruta}inc/components/cnx.php");

/* OBTENER PRODUCTOS DESTACADOS */
$sql = "SELECT p.descripcion, p.precio, p.img, m.nombre AS nombreMarca
FROM productos p
INNER JOIN marcas m ON m.id = p.id_marca
WHERE p.destacado=true";

$ps = $cnx->prepare($sql);
$ps->execute();
$resProductos = $ps->fetchAll();

include("{$ruta}inc/components/header.php");
?>

<nav id="nav">
    <div>
        <img src="./inc/img/portada.jpg" />
    </div>
</nav>

<section id="content">
    <div id="sectionContainer">
        <div class="tituloDestacados">
            <h1>Productos destacados</h1>
        </div>
        <div id="itemsDestacados">
            <?php
            foreach ($resProductos as $producto) {
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
        </div>
    </div>
    <div id="sectionContainer">
        <div class="tituloYoutube">
            <h1>Ultimos videos en Youtube</h1>
        </div>
        <div class="youtubeCanal">
            <iframe src="https://www.youtube.com/embed/KkAbjUBjFtA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <iframe src="https://www.youtube.com/embed/KkAbjUBjFtA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    </div>
</section>

<?php include("{$ruta}inc/components/footer.php"); ?>